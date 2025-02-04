<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        if ($status) {
            if ($search) {
                $data = Transaction::where('status', $status)
                    ->where('code', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%")
                    ->latest()
                    ->paginate(15)
                    ->withQueryString();
                return view('admin.order.index', compact('data', 'search'));
            }
            $data = Transaction::where('status', $status)->latest()->paginate(15)->withQueryString();
            return view('admin.order.index', compact('data'));
        }

        if ($search) {
            $data = Transaction::where('code', 'LIKE', "%$search%")
                ->orWhere('status', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('admin.order.index', compact('data', 'search'));
        }

        $data = Transaction::latest()->paginate(15)->withQueryString();
        return view('admin.order.index', compact('data'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('order', 'user','payment')->findOrFail($id);
        return view('admin.order.show', compact('transaction'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Transaction::findOrFail($id);
            $data->delete();
            Order::where('transaction_id', $data->id)->delete();
            DB::commit();
            if ($data) {
                Alert::success('Success', 'Berhasil Menghapus Data Transaksi!');
                return redirect()->route('order.index');
            } else {
                Alert::success('Error', 'Gagal Menghapus Data Transaksi!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function change_status_order(Request $request, $id)
    {
        $status = $request->status;
        // dd($status);
        DB::beginTransaction();
        try {
            $transaction = Transaction::lockForUpdate()->findOrFail($id);
            switch ($status) {
                case 'pending':
                    $transaction->status = 'process';
                    $transaction->save();
                    break;
                case 'process':
                    $transaction->status = 'packing';
                    $transaction->save();
                    break;
                case 'packing':
                    $transaction->status = 'ready';
                    $transaction->save();
                    break;
                case 'ready':
                    $transaction->status = 'done';
                    $transaction->save();

                    foreach ($transaction->order as $order) {
                        $product = Product::lockForUpdate()->findOrFail($order->product_id);
                        $product->stock -= $order->qty;

                        if ($product->stock < 0) {
                            DB::rollBack();
                            Alert::error('error', 'Stock ' . $order->product_name . ' tidak mencukupi');
                            return redirect()->back();
                        }
                        $product->save();

                        $stock = new Stock();
                        $stock->product_id = $order->product_id;
                        $stock->qty = $order->qty;
                        $stock->type = 'out';
                        $stock->amount = $order->price;
                        $stock->date = now();
                        $stock->description = 'Order Product ' . $order->product_name . ' with transaction code ' . $transaction->code;
                        $stock->save();
                    }
                    break;
                case 'done':
                    Alert::error('error', 'Pesanan Sudah Selesai');
                    return redirect()->back();
                    break;

                default:
                    break;
            }
            DB::commit();
            Alert::success('success', 'Berhasil mengubah status pesanan');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }
}
