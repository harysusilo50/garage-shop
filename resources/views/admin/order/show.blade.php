@extends('admin.layout.app')
@section('title', 'Detail Transaksi ' . $transaction->code)
@section('css')
    <link href="{{ asset('pages/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <a href="{{ route('order.index') }}" class="btn btn-danger btn-sm"> <i class="fa fa-chevron-circle-left"
            aria-hidden="true"></i> Kembali</a>
    <div class="row flex-lg-row-reverse">
        <div class="col-12 col-lg-4 my-2">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">Detail Transaction </h5>
                    <ul class="list-group">
                        <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                            <div class="col-1 text-center me-2"><i class="bi bi-credit-card-2-front text-secondary"
                                    aria-hidden="true"></i>
                            </div>
                            <div class="fw-bold text-secondary">#{{ $transaction->code }}</div>
                        </li>
                        <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                            <div class="col-1 text-center me-2"><i class="bi bi-clipboard text-secondary"
                                    aria-hidden="true"></i></div>
                            <div> @switch($transaction->status)
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
                            </div>
                        </li>

                        <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                            <div class="col-1 text-center me-2"><i class="bi bi-calendar text-secondary"
                                    aria-hidden="true"></i></div>
                            <div>{{ $transaction->format_date }}</div>
                        </li>
                        <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                            <div class="col-1 text-center me-2"><i class="bi bi-cash-coin text-secondary"
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
                            <div>{{ $transaction->user->address }}</div>
                        </li>
                    </ul>
                    <hr class="border-1 border-bottom border-secondary-subtle">
                    <p class="fw-bold text-secondary"> <i class="fa fa-credit-card" aria-hidden="true"></i> Payment
                        Method
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item bg-light border-0">
                            {{ $transaction->payment_method }}
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-8 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Order <span>| {{ $transaction->code }}</span></h5>
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
                                    <td colspan="3" class="text-center fw-bold">Total Harga</td>
                                    <td class="fw-bold">Rp {{ $transaction->format_total_price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($transaction->status == 'ready' || $transaction->status == 'done')
                        <a href="{{ route('order.invoice', $transaction->code) }}" target="_blank"
                            class="btn btn-success btn-sm">Cetak
                            Struk
                            Order <i class="bi bi-printer-fill"></i></a>
                    @endif
                </div>
            </div>
            @if (Auth::user()->role != 'admin_kepala')
                <div class="card">
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
@endsection
