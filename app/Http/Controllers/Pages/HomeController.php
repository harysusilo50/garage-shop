<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kodepandai\LaravelRajaOngkir\Facades\RajaOngkir;

class HomeController extends Controller
{
    public function index()
    {

        $title = 'Home';
        $cart = (new Cart())->total_cart();
        $banner = Banner::all();
        $product = Product::with(['photo'])
            ->where('stock', '>', 0)
            ->where('is_active', 'yes')
            ->latest()
            ->paginate(15)
            ->withQueryString();
        return view('pages.home.main', compact('title', 'product', 'cart', 'banner'));
    }

    public function show_category(Request $request)
    {
        $name = $request->name ?? 'Home';
        $category = Category::select('name', 'slug', 'icon')->get();
        $product_category = Category::with([
            'product' => function ($value) {
                $value->where('is_active', 'yes')->where('stock', '>', 0);
            },
        ])
            ->where('slug', $request->name)
            ->first();
        $icon = $product_category->icon;
        $title = $product_category->name;
        $cart = (new Cart())->total_cart();
        return view('pages.home.category', compact('title', 'icon', 'product_category', 'cart'));
    }
    public function search(Request $request)
    {
        $search = $request->get('search');
        $title = 'Search';
        $cart = (new Cart())->total_cart();
        if (Auth::guest()) {
            $cart = 0;
            $product = Product::with('photo')
                ->where('stock', '>', 0)
                ->where('is_active', 'yes')
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('slug', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('pages.home.search', compact('title',  'product', 'cart', 'search'));
        }

        $product = Product::with(['photo'])
            ->where('stock', '>', 0)
            ->where('is_active', 'yes')
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('slug', 'LIKE', "%$search%")
            ->orWhere('code', 'LIKE', "%$search%")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.home.search', compact('title', 'product', 'cart', 'search'));
    }


}
