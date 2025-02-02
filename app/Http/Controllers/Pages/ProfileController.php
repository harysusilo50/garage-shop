<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public function show_profile(Request $request, $id)
    {
        $check = (new Hashids(env('APP_KEY'), '15'))->decode($id);

        if ($check[0] != Auth::id() && Auth::user()->role == 'user') {
            abort('403');
        }
        $title = 'Profile';
        $category = Category::select('name', 'slug', 'icon')->get();
        $cart = (new Cart())->total_cart();

        $user = User::with('transaction',)->findOrFail($check[0]);
        $user_cart = Cart::where('user_id', $user->id)->count();
        $user_transaction = $user->transaction->count();

        $search = $request->get('search');
        if ($search) {
            $transaction = $user->transaction()->where('code', 'LIKE', "%$search%")
                ->orWhere('status', 'LIKE', "%$search%")->latest()->paginate(15)->withQueryString();
            return view('pages.profile.index', compact('title', 'user', 'category', 'cart', 'user_cart', 'user_transaction', 'transaction', 'search'));
        }
        $transaction = $user->transaction()->with('order')->latest()->paginate(15)->withQueryString();
        return view('pages.profile.index', compact('title', 'user', 'category', 'cart', 'user_cart', 'user_transaction', 'transaction'));
    }
}
