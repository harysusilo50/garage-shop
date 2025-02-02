@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('css')
    <link href="{{ asset('pages/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <section class="section dashboard">
        <h3 class="mb-3">Penjualan</h3>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Penjualan Hari Ini
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="ps-3">
                                <h4 class="fw-bold">Rp{{ number_format($sales_day, 0, ',', '.') }}</h4>
                                <small class="fw-bold text-muted">{{ Carbon\Carbon::now()->locale('Id')->dayName }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Penjualan Bulan Ini
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center text-white"
                                style="background-color:#dc35468f">
                                <i class="bi bi-calendar-week"></i>
                            </div>

                            <div class="ps-3">
                                <h4 class="fw-bold">Rp{{ number_format($sales_month, 0, ',', '.') }}</h4>
                                <small class="fw-bold text-muted">{{ Carbon\Carbon::now()->monthName }}</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Penjualan Tahun Ini
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar3"></i>
                            </div>

                            <div class="ps-3">
                                <h4 class="fw-bold">Rp{{ number_format($sales_year, 0, ',', '.') }}</h4>
                                <small class="fw-bold text-muted">{{ Carbon\Carbon::now()->year }}</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mb-3">Produk</h3>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Total Produk
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-archive"></i>
                            </div>
                            <div class="ps-3">
                                <h4 class="fw-bold">{{ $total_product }}</h4>
                                <small class="fw-bold text-muted">Total Jenis Produk</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Stock hampir habis
                        </h5>
                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center text-white bg-success">
                                <i class="bi bi-inboxes"></i>
                            </div>

                            <div class="ps-3">
                                <h4 class="fw-bold">{{ $stock_habis }}</h4>
                                <small class="fw-bold text-muted">Produk </small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Pesanan Pending
                        </h5>
                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white">
                                <i class="bi bi-box-arrow-in-down"></i>
                            </div>

                            <div class="ps-3">
                                <h4 class="fw-bold">{{ $pending_order->total() }}</h4>
                                <small class="fw-bold text-muted">Pesanan belum dikonfirmasi</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card info-card customers-card">
                <div class="card-body p-3">
                    <h5 class="card-title">List Pesanan Pending <span>| Semua Pesanan Belum dikonfirmasi</span></h5>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kode Transaksi</th>
                                    <th>Oleh</th>
                                    <th>Total Harga</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending_order as $item)
                                    <tr>
                                        <td class="text-center" style="width:5%">
                                            {{ $pending_order->firstItem() + $loop->index }}</td>
                                        <td class="text-center">
                                            {{ $item->format_date }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->code }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->user->name }}
                                        </td>
                                        <td>
                                            Rp {{ $item->format_total_price }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->payment_method }}
                                        </td>
                                        <td class="text-center">
                                            @switch($item->status)
                                                @case('pending')
                                                    <span class="badge rounded-pill text-bg-secondary">Pending</span>
                                                @break

                                                @case('process')
                                                    <span class="badge rounded-pill text-bg-info text-white">Process</span>
                                                @break

                                                @case('packing')
                                                    <span class="badge rounded-pill text-bg-primary">Packing</span>
                                                @break

                                                @case('ready')
                                                    <span class="badge rounded-pill text-bg-warning text-white">Ready</span>
                                                @break

                                                @case('done')
                                                    <span class="badge rounded-pill text-bg-success">Done</span>
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td class="text-center" style="width: 10%">
                                            <a class="btn btn-success btn-sm" href="{{ route('order.show', $item->id) }}">
                                                Detail Transaksi
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $pending_order->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
