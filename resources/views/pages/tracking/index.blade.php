@extends('pages.checkout.layout')
@section('title', 'Order Tracking ' . $code)
@section('content')
    <div class="container bg-white text-center py-2 rounded-2 col-12 col-lg-8">
        <h3 class="fw-bold">Order Tracking #{{ $code }}</h3>
    </div>
    <div class="container mt-3 col-12 col-lg-8 mb-5">
        @if ($transaction)
            <div class="row flex-lg-row-reverse">
                <div class="col-12 col-lg-4 my-2">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">Detail Transaction </h5>
                            <ul class="list-group">
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa  text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="fw-bold text-secondary">#{{ $transaction->code }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="bi bi-clipboard text-secondary"
                                            aria-hidden="true"></i></div>
                                    <div> @switch($transaction->status)
                                        @case('pending')
                                        <span class="badge rounded-pill text-bg-secondary">Menunggu Pembayaran</span>
                                    @break

                                    @case('process')
                                        <span class="badge rounded-pill text-bg-info text-white">Sedang Dalam Proses Konfirmasi</span>
                                    @break

                                    @case('packing')
                                        <span class="badge rounded-pill text-bg-primary">Dalam Pengemasan</span>
                                    @break

                                    @case('ready')
                                        <span class="badge rounded-pill text-bg-warning text-white">Barang Dalam Pengiriman</span>
                                    @break

                                    @case('done')
                                        <span class="badge rounded-pill text-bg-success">Selesai</span>
                                    @break

                                            @default
                                        @endswitch
                                    </div>
                                </li>

                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i
                                            class="fa fa-calendar text-secondary"aria-hidden="true"></i>
                                    </div>
                                    <div>{{ $transaction->format_date }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-money text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="fw-bold text-secondary">Rp {{ $transaction->format_total_price }}</div>
                                </li>
                            </ul>
                            <hr class="border-1 border-bottom border-secondary-subtle">
                            <p class="fw-bold text-secondary "> <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                Delivery
                                Address
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-user-circle-o text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>{{ $transaction->user->name }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-envelope-o text-secondary"
                                            aria-hidden="true"></i></div>
                                    <div>{{ $transaction->user->email }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-whatsapp text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>{{ $transaction->user->phone }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-map-marker text-secondary"
                                            aria-hidden="true"></i></div>
                                    <div>{{ $data->shipping->address }}</div>
                                </li>
                            </ul>
                            <hr class="border-1 border-bottom border-secondary-subtle">
                            <p class="fw-bold text-secondary"> <i class="fa fa-credit-card" aria-hidden="true"></i> Payment
                                Method
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2">
                                        <i class="fa fa-dot-circle-o text-secondary" aria-hidden="true"></i>
                                    </div>
                                    <div>{{ $transaction->payment_method }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-8 my-2">

                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">Detail Order <span>| {{ $transaction->code }}</span></h5>
                            @if ($transaction->status == 'ready' || $transaction->status == 'done')
                                <a href="{{ route('order.invoice', $transaction->code) }}" target="_blank"
                                    class="btn btn-success btn-sm my-2">Cetak
                                    Struk
                                    Order <i class="fa fa-print"></i></a>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Produk [Variant]</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->order as $item)
                                            <tr>
                                                <td class="text-center" style="width:5%">
                                                    {{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->product_name }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->qty }}
                                                </td>
                                                <td>
                                                    Rp {{ $item->format_price }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-center fw-bold">
                                                Jasa Pengiriman
                                            </td>
                                            <td class="fw-bold">Rp
                                                {{ $transaction->shipping->format_cost }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-center fw-bold">Total Harga</td>
                                            <td class="fw-bold">Rp {{ $transaction->format_total_price }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin_toko')
                        <div class="card border-0">
                            <div class="card-body py-3 d-flex justify-content-around">
                                <form action="{{ route('order.change-status', $transaction->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="status" class="d-none" value="{{ $transaction->status }}">
                                    @switch($transaction->status)
                                        @case('pending')
                                            <button class="btn btn-secondary" type="submit">
                                                Konfirmasi Pesanan
                                            </button>
                                        @break

                                        @case('process')
                                            <button class="btn btn-info text-white" type="submit">
                                                Packing Pesanan
                                            </button>
                                        @break

                                        @case('packing')
                                            <button class="btn btn-primary" type="submit">
                                                Pesanan Siap
                                            </button>
                                        @break

                                        @case('ready')
                                            <button class="btn btn-success" type="submit">
                                                Selesaikan Pesanan
                                            </button>
                                        @break

                                        @default
                                    @endswitch
                                </form>
                                <form action="{{ route('order.destroy', $transaction->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">
                                        Hapus Pesanan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="text-center m-auto">
                <img class="w-50" src="{{ asset('img/search.svg') }}" alt="not found">
            </div>
            <h2 class="text-center mt-5">
                Data tidak ditemukan
            </h2>
        @endif
    </div>
@endsection
