@extends('pages.layout.app')
@section('title', 'Profile ' . $user->name)
@section('breadcrumb')
    <nav class="bg-white ">
        <div class="container px-4 ">
            <a class="btn btn-outline-light rounded-0 text-muted" href="{{ route('home') }}">
                <i class="fa fa-home" aria-hidden="true"></i></a>
            <span class="bg-white rounded-0 align-middle px-2">
                <small>
                    <i class="fa fa-chevron-right text-muted" aria-hidden="true"></i>
                </small>
            </span>
            <a class="btn btn-outline-light active rounded-0 fw-bold text-muted" href="{{ request()->fullUrl() }}">
                <small>
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    Profile
                </small>
            </a>
        </div>
    </nav>
@endsection
@section('content')
    <div class="container mt-3">
        <div class="row ">
            <div class="col-12 col-lg-4">
                <div class="card border-0 rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('img/user.png') }}" alt="user.png" style="width: 100px">
                        </div>
                        <h4 class="text-center mb-0">{{ $user->name }}</h4>
                        <p class="text-center mt-0">{{ $user->email }}</p>
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="text-center mb-0 pb-0">
                                    <td class="mb-0 pb-0 fs-3 fw-bold" style="width: 33%">{{ $user_cart }}</td>
                                    <td class="mb-0 pb-0 fs-3 fw-bold" style="width: 33%">{{ $user_transaction }}</td>
                                </tr>
                                <tr class="text-center mt-0 pt-0">
                                    <td class="my-0 py-0">Keranjang</td>
                                    <td class="my-0 py-0">Transaksi</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width:10%"><i class="fa fa-address-book text-muted"></i>
                                    </td>
                                    <td>{{ $user->address }}</td>
                                <tr>
                                    <td class="text-center" style="width:10%"><i class="fa fa-phone text-muted"></i></td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width:10%"><i
                                            class="fa fa-check-square-o text-muted"></i></td>
                                    <td>Verified At
                                        {{ Carbon\Carbon::parse($user->email_verified_at)->format('H:i | d F Y') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 mt-3 mt-lg-0">
                <div class="card border-0 rounded-0">
                    <div class="card-body p-3">
                        <h5 class="card-title">Riwayat Transaksi</span></h5>
                        <div class="d-lg-flex justify-content-lg-end mb-3 d-block">
                            <form action="{{ route('pages.profile.index', Auth::user()->hash_id) }}" method="GET">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control rounded-0" placeholder="Cari Riwayat Pesanan"
                                        name="search" aria-label="Search Order" value="{{ $search ?? '' }}"
                                        aria-describedby="search_button" />
                                    <button class="btn btn-success rounded-0" type="submit" id="search_button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                @if (!empty($search))
                                    <div class="text-end">
                                        <a href="{{ route('pages.profile.index', Auth::user()->hash_id) }}"
                                            class="btn btn-sm btn-danger">
                                            Reset
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center align-middle">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kode Transaksi</th>
                                        <th>Total Harga</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction as $item)
                                        <tr>
                                            <td class="text-center" style="width:5%">
                                                {{ $transaction->firstItem() + $loop->index }}</td>
                                            <td class="text-center">
                                                {{ $item->format_date }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->code }}
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
                                                        <span class="badge rounded-pill text-bg-secondary">Menunggu
                                                            Pembayaran</span>
                                                    @break

                                                    @case('process')
                                                        <span class="badge rounded-pill text-bg-info text-white">Sedang Dalam Proses
                                                            Konfirmasi</span>
                                                    @break

                                                    @case('packing')
                                                        <span class="badge rounded-pill text-bg-primary">Dalam Pengemasan</span>
                                                    @break

                                                    @case('ready')
                                                        <span class="badge rounded-pill text-bg-warning text-white">Barang Dalam
                                                            Pengiriman</span>
                                                    @break

                                                    @case('done')
                                                        <span class="badge rounded-pill text-bg-success">Selesai</span>
                                                    @break

                                                    @default
                                                    @break
                                                @endswitch
                                            </td>
                                            <td class="text-center" style="width: 10%">
                                                <a class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal_transaction_{{ $item->id }}">
                                                    Detail Transaksi
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @foreach ($transaction as $value)
                                <!-- Modal -->
                                <div class="modal fade" id="modal_transaction_{{ $value->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modalTitle{{ $value->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle{{ $value->id }}">
                                                    Transaction Detail #{{ $value->code }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 col-lg-8 my-2">
                                                        @if ($value->status == 'pending')
                                                            <a href="{{ route('payment.index', $value->code) }}"
                                                                target="_blank" class="btn btn-primary btn-sm my-2">Kirim
                                                                Bukti Pembayaran <i class="fa fa-send"></i></a>
                                                        @endif
                                                        @if ($value->status == 'process')
                                                            <a href="{{ $value->payment->payment_img_url }}"
                                                                target="_blank"
                                                                class="btn btn-secondary btn-sm my-2">Lihat
                                                                Bukti Pembayaran <i class="fa fa-file"></i></a>
                                                        @endif
                                                        @if ($value->status == 'ready' || $value->status == 'done' || $value->status == 'process')
                                                            <a href="{{ $value->payment->payment_img_url }}"
                                                                target="_blank"
                                                                class="btn btn-secondary btn-sm my-2">Lihat
                                                                Bukti Pembayaran <i class="fa fa-file"></i></a>
                                                            <a href="{{ route('order.invoice', $value->code) }}"
                                                                target="_blank" class="btn btn-success btn-sm my-2">Cetak
                                                                Struk
                                                                Order <i class="fa fa-print"></i></a>
                                                        @endif
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="table_id"
                                                                width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        <th>No</th>
                                                                        <th>Produk [Variant]</th>
                                                                        <th>Jumlah</th>
                                                                        <th>Harga</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($value->order as $item)
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
                                                                            {{ $value->shipping->format_cost ?? '' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" class="text-center fw-bold">
                                                                            Total Harga
                                                                        </td>
                                                                        <td class="fw-bold">Rp
                                                                            {{ $value->format_total_price }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 my-2">
                                                        <div class="card border-0">
                                                            <p class="fw-bold text-secondary ">
                                                                <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                                                Delivery
                                                                Address
                                                            </p>
                                                            <ul class="list-group">
                                                                <li
                                                                    class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                                                    <div class="col-1 text-center me-2"><i
                                                                            class="fa fa-user-circle-o text-secondary"
                                                                            aria-hidden="true"></i>
                                                                    </div>
                                                                    <div>{{ $value->user->name }}</div>
                                                                </li>
                                                                <li
                                                                    class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                                                    <div class="col-1 text-center me-2"><i
                                                                            class="fa fa-envelope-o text-secondary"
                                                                            aria-hidden="true"></i></div>
                                                                    <div>{{ $value->user->email }}</div>
                                                                </li>
                                                                <li
                                                                    class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                                                    <div class="col-1 text-center me-2"><i
                                                                            class="fa fa-whatsapp text-secondary"
                                                                            aria-hidden="true"></i>
                                                                    </div>
                                                                    <div>{{ $value->user->phone }}</div>
                                                                </li>
                                                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                                                    <div class="col-1 text-center me-2"><i class="fa fa-map-marker text-secondary"
                                                                            aria-hidden="true"></i></div>
                                                                    <div>{{ $value->shipping->address ?? ''}}</div>
                                                                </li>
                                                            </ul>
                                                            <hr class="border-1 border-bottom border-secondary-subtle">
                                                            <p class="fw-bold text-secondary"> <i
                                                                    class="fa fa-credit-card" aria-hidden="true"></i>
                                                                Payment
                                                                Method
                                                            </p>
                                                            <ul class="list-group">
                                                                <li class="list-group-item bg-light border-0">
                                                                    {{ $value->payment_method }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center">
                                {{ $transaction->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
