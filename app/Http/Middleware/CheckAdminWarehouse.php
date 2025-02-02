<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminWarehouse
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'warehouse' || Auth::user()->role == 'admin_toko' || Auth::user()->role == 'admin_kepala') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
