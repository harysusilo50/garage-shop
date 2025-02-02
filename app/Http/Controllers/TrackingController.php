<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->code;
        if (!$code) {
            abort(404);
        }
        $transaction = Transaction::where('code', $request->code)->first();

        return view('pages.tracking.index', compact('transaction', 'code'));
    }
}
