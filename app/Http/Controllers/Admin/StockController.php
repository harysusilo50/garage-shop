<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = Product::with('photo', 'stock_product')
                ->where('name', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();

            foreach ($data as $value) {
                if ($value->stock_product->isNotEmpty()) {
                    $value->stock_in = $value->stock_product->where('type', 'in')->sum('qty');
                    $value->stock_out = $value->stock_product->where('type', 'out')->sum('qty');
                } else {
                    $value->stock_in = 0;
                    $value->stock_out = 0;
                }
            }
            return view('admin.stock.index', compact('data', 'search'));
        }
        $data = Product::with('photo', 'stock_product')->latest()->paginate(15)->withQueryString();
        foreach ($data as $value) {
            if ($value->stock_product->isNotEmpty()) {
                $value->stock_in = $value->stock_product->where('type', 'in')->sum('qty');
                $value->stock_out = $value->stock_product->where('type', 'out')->sum('qty');
            } else {
                $value->stock_in = 0;
                $value->stock_out = 0;
            }
        }

        return view('admin.stock.index', compact('data'));
    }

    public function report(Request $request)
    {
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        if ($date_start || $date_end) {
            $date_start = empty($date_start) ? now() : $date_start;
            $date_end = empty($date_end) ? now() : $date_end;
            $data = Stock::with('product')->whereDate('date', '>=', $date_start)
                ->whereDate('date', '<=', $date_end)
                ->orderBy('date', 'ASC')
                ->latest()
                ->get();

            $barang_keluar = Stock::where('type', 'out')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('qty');
            $barang_masuk = Stock::where('type', 'in')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('qty');

            $total_produk = Stock::whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->count();
            $pdf = Pdf::loadView('admin.stock.report_pdf', ['data' => $data, 'barang_keluar' => $barang_keluar, 'barang_masuk' => $barang_masuk, 'total_produk' => $total_produk, 'date_start' => $date_start, 'date_end' => $date_end]);
            return $pdf->stream('report_in_out_product' . now() . '.pdf');
        }

        $barang_keluar = Stock::where('type', 'out')->sum('qty');
        $barang_masuk = Stock::where('type', 'in')->sum('qty');
        $total_produk = Stock::count();

        $data = Stock::with('product')->latest()->get();
        $pdf = Pdf::loadView('admin.stock.report_pdf', ['data' => $data, 'barang_keluar' => $barang_keluar, 'barang_masuk' => $barang_masuk, 'total_produk' => $total_produk]);
        return $pdf->stream('report_in_out_product' . now() . '.pdf');
    }

    public function add(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $stock = new Stock();
            $stock->product_id = $id;
            $stock->qty = $request->qty;
            $stock->type = 'in';
            $stock->amount = $request->amount;
            $stock->date = $request->date;
            $stock->description = $request->notes;
            $stock->save();

            $product = Product::lockForUpdate()->findOrFail($id);
            $product->stock += $stock->qty;
            $product->save();

            DB::commit();
            Alert::success('success', 'Berhasil menambah Stok Produk');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Stock::findOrFail($id);
            $data->delete();
            DB::commit();
            if ($data) {
                Alert::success('Success', 'Berhasil Menghapus Data Transaksi!');
                return redirect()->route('product.stock.report');
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
}
