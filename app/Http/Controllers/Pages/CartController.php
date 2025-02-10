<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function index()
    {
        $title = 'Cart';
        $cart = Cart::where('user_id', Auth::id())
            ->with([
                'product' => function ($value) {
                    $value->where('is_active', 'yes')->where('stock', '>', 0);
                },
            ])
            ->get();
        return view('pages.home.cart', compact('title', 'cart'));
    }

    public function add(Request $request, $product_id)
    {
        try {
            // Cek apakah produk ada di database
            $product = Product::find($product_id);
            if (!$product) {
                Alert::error('error', 'Produk tidak ditemukan!');
                return redirect()->back();
            }
    
            // Cek apakah produk sudah ada di keranjang
            $cart = Cart::where(['product_id' => $product_id, 'user_id' => Auth::id()])->first();
    
            if ($cart) {
                // Jika sudah ada, update qty
                $cart->qty += $request->qty ?? 1;
            } else {
                // Jika belum ada, buat entri baru
                $cart = new Cart();
                $cart->qty = $request->qty ?? 1;
                $cart->product_id = $product_id;
                $cart->user_id = Auth::id();
            }
    
            // Simpan data ke database
            if ($cart->save()) {
                Alert::success('success', 'Berhasil menambah produk ke dalam keranjang!');
            } else {
                Alert::error('error', 'Gagal menambah produk ke dalam keranjang!');
            }
    
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
            return redirect()->back();
        }
    }
    

    public function destroy($id)
    {
        try {
            $data = Cart::findOrFail($id);
            $data->delete();
            if ($data) {
                Alert::success('Success', 'Berhasil Menghapus Produk dari Keranjang!');
                return redirect()->back();
            } else {
                Alert::success('Error', 'Gagal Menghapus Produk dari Keranjang!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
