@extends('admin.layout.app')
@section('title', 'Semua Pesanan')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">List <span>| Order</span></h5>
                            <div class="d-lg-flex justify-content-lg-end mb-3 d-block">
                                <form action="{{ route('order.index') }}" method="GET">
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control" placeholder="Search Order" name="search"
                                            aria-label="Search Order" value="{{ $search ?? '' }}"
                                            aria-describedby="search_button" />
                                        <button class="btn btn-success" type="submit" id="search_button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    @if (!empty($search))
                                        <div class="text-end">
                                            <a href="{{ route('order.index') }}" class="btn btn-sm btn-danger">
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
                                            <th>Oleh</th>
                                            <th>Total Harga</th>
                                            <th>Pembayaran</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center" style="width:5%">
                                                    {{ $data->firstItem() + $loop->index }}</td>
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
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('order.show', $item->id) }}">
                                                        Detail Transaksi
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
@endsection
