<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sales_day = Stock::where('type', 'out')->whereDate('date', Carbon::now())->sum('amount');
        $sales_month = Stock::where('type', 'out')->whereMonth('date', Carbon::now()->month)->sum('amount');
        $sales_year = Stock::where('type', 'out')->whereYear('date', Carbon::now()->year)->sum('amount');

        $total_product = Product::where('is_active', 'yes')->count();

        $stock_habis = Product::where('stock', '<', 5)->count();

        $pending_order = Transaction::where('status', 'process')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.home.dashboard', compact('sales_day', 'sales_month', 'sales_year', 'pending_order', 'total_product', 'stock_habis'));
    }
}
