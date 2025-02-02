<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminBendahara
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'bendahara' || Auth::user()->role == 'admin_kepala') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
