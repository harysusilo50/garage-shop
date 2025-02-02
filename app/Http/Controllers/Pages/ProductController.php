<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function show(Request $request, $slug)
    {
        $product = Product::with('brand', 'variant', 'photo')->where('stock', '>', 0)->where('slug', $slug)->first();
        $title = $product->category->name;
        $category = Category::select('name', 'slug', 'icon')->get();
        $cart = (new Cart())->total_cart();

        return view('pages.product.show', compact('product', 'title', 'cart'));
    }
}
