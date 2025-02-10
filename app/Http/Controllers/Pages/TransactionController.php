<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShippingCost;
use App\Models\Transaction;
use App\Models\VariantProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        
        try {
            $this->validate(
                $request,
                [
                    'product_id' => 'required',
                    'qty' => 'required|min:1',
                ],
                [
                    'product_id.required' => 'Produk harus diisi!',
                    'qty.required' => 'Jumlah Produk harus diisi!',
                    'qty.required' => 'Jumlah Produk minimal 1!',
                ],
            );

            if (!is_array($request->product_id)) {
                $product = Product::where('id', $request->product_id)->get();
                $qty[] = $request->qty;
                return view('pages.checkout.index', compact('product', 'qty',));
            }

            $cart = Cart::where('user_id', Auth::id())->whereIn('product_id', $request->product_id)
                ->with([
                    'product' => function ($value) {
                        $value->where('is_active', 'yes');
                    },
                ])
                ->get();
            $product = $cart->map(function ($element) {
                $element->product->cart_id = $element->id;
                return $element->product;
            });
            $qty = $request->qty;
            return view('pages.checkout.index', compact('product', 'qty'));
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function checkout_process(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate(
                $request,
                [
                    'product_id' => 'required|array',
                    'qty' => 'required|min:1|array',
                ],
                [
                    'product_id.required' => 'Produk harus diisi!',
                    'qty.required' => 'Jumlah Produk harus diisi!',
                    'qty.required' => 'Jumlah Produk minimal 1!',
                    'qty.required' => 'Jumlah Produk minimal 1!',
                ],
            );

            if (!is_array($request->product_id) && !is_array($request->qty)) {
                Alert::error('error', 'Masukan format dengan benar');
                return redirect()->back();
            }
            $product_name = [];
            // $qty = array();
            $array_price = [];
            $total_price = 0;
            for ($key = 0; $key < count($request->product_id); $key++) {
                $product = Product::findOrFail($request->product_id[$key]);
                $product->stock -= $request->qty[$key];
                if ($product->stock < 0) {
                    DB::rollBack();
                    Alert::error('error', 'Stock ' . $product->name . ' tidak mencukupi');
                    return redirect()->route('home');
                }

                $product_name[$key] = $product->name;

                $price = $product->discount_price ?? $product->price;
                $price = $price * $request->qty[$key];
                $array_price[] = $price;
                $total_price += $price;
            }

            $transaction = new Transaction();
            $transaction->user_id = Auth::id();
            $transaction->code = 'NOTA' . date('Ymd') . 'TRX' . rand(0, 999999);
            $transaction->status = 'pending';
            $transaction->payment_method = $request->payment_method;
            $transaction->date = now();
            $transaction->total_price = $total_price + intval($request->service);
            $transaction->save();

            $product_id_cart = [];
            for ($key = 0; $key < count($request->product_id); $key++) {
                $order = new Order();
                $order->product_id = $request->product_id[$key];
                $order->transaction_id = $transaction->id;
                $order->product_name = $product_name[$key];
                $order->qty = $request->qty[$key];
                $order->price = $array_price[$key];
                $order->save();

                $product_id_cart[] = $request->product_id[$key];
            }

            $shipping = new ShippingCost();
            $shipping->transaction_id = $transaction->id;
            $shipping->address = $request->address_full;
            $shipping->courier = $request->kurir;
            $shipping->service = '-';
            $shipping->cost = intval($request->service);
            $shipping->save();

            Cart::where('user_id', Auth::id())->whereIn('product_id',$product_id_cart)->delete();
            DB::commit();
            Alert::success('success', 'Pesanan berhasil dibuat, silakan lakukan pembayaran!');
            return redirect()->route('payment.index', $transaction->code);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function payment_order(Request $request, $code)
    {
        $data = Transaction::with('order', 'user','shipping')->where('code', $code)->firstOrFail();
        return view('pages.checkout.payment', compact('data'));
    }

    public function payment_process(Request $request, $transaction_id) {
        try {
            $transaction = Transaction::findOrFail($transaction_id);
            $data = new Payment();
            $data->transaction_id = $request->transaction_id;
            $data->sender_name = $request->sender_name;
            $data->bank_name = $request->bank_name;
            $data->no_rek = $request->no_rek;
            if ($request->hasFile('payment_img')) {
                $file = $request->file('payment_img');
                $path = $file->store('payment', 'public');
            }
            $data->payment_img =  $path;
            $data->save();
    
            $transaction->status = 'process';
            $transaction->save();

            DB::commit();
            Alert::success('success', 'Bukti pembayaran telah berhasil dikirim, mohon tunggu proses verifikasi pembayaran!');
            return redirect()->route('home');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
      
    }

    public function invoice($id)
    {
        $data = Transaction::with('order', 'user','shipping')->where('code', $id)->firstOrFail();
        $pdf = Pdf::loadView('admin.order.invoice', ['data' => $data]);
        return $pdf->stream('invoice' . $data->code . '_' . now() . '.pdf');
    }

    public function cariAlamatOngkir(Request $request)
    {
        $alamat = $request->search;

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.urlencode($alamat),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'key: '.env('RAJAONGKIR_KEY'),
            'Accept: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $data = json_decode($response);
        return $data->data;
    }

    public function calculateOngkir(Request $request)
    {
        $origin = '17482';
        $destination = $request->destination_id;
        $kurir = $request->kurir;
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'courier='.$kurir.'&destination='.$destination.'&origin='.$origin.'&weight=500',
          CURLOPT_HTTPHEADER => array(
            'key: '.env('RAJAONGKIR_KEY'),
            'Accept: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $data = json_decode($response);
        return $data->data;
    }
}
