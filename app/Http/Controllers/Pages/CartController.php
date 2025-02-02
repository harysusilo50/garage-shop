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
        $category = Category::select('name', 'slug', 'icon')->get();
        $cart = Cart::where('user_id', Auth::id())->with(['product' => function ($value) {
            $value->where('is_active', 'yes')->where('stock', '>', 0);
        }])->get();
        return view('pages.home.cart', compact('title', 'category', 'cart'));
    }

    public function add($product_id)
    {
        try {
            $check = Product::find($product_id);
            if ($check) {
                $data = new Cart();
                $data->product_id = $product_id;
                $data->user_id = Auth::id();
                $data->save();
                if ($data) {
                    Alert::success('success', 'Berhasil menambah produk ke dalam keranjang!');
                    return redirect()->back();
                } else {
                    Alert::error('error', 'Gagal menambah produk ke dalam keranjang!');
                    return redirect()->back();
                }
            }
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
