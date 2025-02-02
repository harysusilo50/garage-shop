<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        if ($date_start || $date_end) {
            $date_start = empty($date_start) ? now() : $date_start;
            $date_end = empty($date_end) ? now() : $date_end;
            $data = Stock::with('product')->whereDate('date', '>=', $date_start)
                ->whereDate('date', '<=', $date_end)
                ->orderBy('date', 'DESC')
                ->paginate(30)
                ->withQueryString();

            $pemasukan = Stock::where('type', 'out')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('amount');
            $pengeluaran = Stock::where('type', 'in')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('amount');
            $keuntungan = $pemasukan - $pengeluaran;
            return view('admin.finance.index', compact('data', 'pemasukan', 'pengeluaran', 'keuntungan', 'date_start', 'date_end'));
        }

        $pemasukan = Stock::where('type', 'out')->sum('amount');
        $pengeluaran = Stock::where('type', 'in')->sum('amount');
        $keuntungan = $pemasukan - $pengeluaran;

        $data = Stock::with('product')->latest()->paginate(30)->withQueryString();
        return view('admin.finance.index', compact('data', 'pemasukan', 'pengeluaran', 'keuntungan'));
    }

    public function report(Request $request)
    {
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        if ($date_start || $date_end) {
            $date_start = empty($date_start) ? now() : $date_start;
            $date_end = empty($date_end) ? now() : $date_end;
            $data = Stock::with('product')->whereDate('date', '>=', $date_start)
                ->whereDate('date', '<=', $date_end)
                ->orderBy('date', 'DESC')
                ->get();

            $pemasukan = Stock::where('type', 'out')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('amount');
            $pengeluaran = Stock::where('type', 'in')->whereDate('date', '>=', $date_start)->whereDate('date', '<=', $date_end)->sum('amount');
            $keuntungan = $pemasukan - $pengeluaran;


            $pdf = Pdf::loadView('admin.finance.report', ['data' => $data, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran, 'keuntungan' => $keuntungan, 'date_start' => $date_start, 'date_end' => $date_end]);
            return $pdf->stream();
        }

        $pemasukan = Stock::where('type', 'out')->sum('amount');
        $pengeluaran = Stock::where('type', 'in')->sum('amount');
        $keuntungan = $pemasukan - $pengeluaran;

        $data = Stock::with('product')->latest()->get();
        $pdf = Pdf::loadView('admin.finance.report', ['data' => $data, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran, 'keuntungan' => $keuntungan]);
        return $pdf->stream('report_finance_' . now() . '.pdf');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Stock::findOrFail($id);
            $data->delete();
            DB::commit();
            if ($data) {
                Alert::success('Success', 'Berhasil Menghapus Data Transaksi!');
                return redirect()->route('finance.index');
            } else {
                Alert::success('Error', 'Gagal Menghapus Data Transaksi!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
