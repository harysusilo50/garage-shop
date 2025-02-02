@extends('admin.layout.app')
@section('title', 'Laporan Stok Produk')
@section('css')
    <link href="{{ asset('pages/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Barang Masuk
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-box-arrow-in-down-left"></i>
                            </div>
                            <div class="ps-3">
                                <h4 class="fw-bold">{{ $barang_masuk }}</h4>
                                @if (!empty($date_start) && !empty($date_end))
                                    <small>{{ Carbon\Carbon::parse($date_start)->format('d M Y') }} -
                                        {{ Carbon\Carbon::parse($date_end)->format('d M Y') }}</small>
                                @else
                                    <small class="fw-bold text-muted">Hari ini</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Barang Keluar / Terjual
                        </h5>
                        <div class="d-flex align-items-center">
                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </div>
                            <div class="ps-3 ">
                                <h4 class="fw-bold">{{ $barang_keluar }}</h4>
                                @if (!empty($date_start) && !empty($date_end))
                                    <small>{{ Carbon\Carbon::parse($date_start)->format('d M Y') }} -
                                        {{ Carbon\Carbon::parse($date_end)->format('d M Y') }}</small>
                                @else
                                    <small class="fw-bold text-muted">Hari ini</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <div class="my-2">
                                <h5 class="card-title">Stock Report</span></h5>
                            </div>
                            <div class="d-lg-flex justify-content-lg-end mb-3 d-block">
                                <form action="{{ route('product.stock.report') }}" method="GET">
                                    <div class="my-2 d-flex justify-content-between">
                                        <input type="date" class="form-control" name="date_start"
                                            value="{{ $date_start ?? '' }}" />
                                        <input type="date" class="form-control" name="date_end"
                                            value="{{ $date_end ?? '' }}" />
                                    </div>
                                    <div class="text-end mb-2">
                                        <a target="_blank"
                                            href="{{ route('stock.report', ['date_start' => $date_start ?? '', 'date_end' => $date_end ?? '']) }}"
                                            class="btn btn-primary">
                                            Report <i class="bi bi-download"></i>
                                        </a>
                                        <button class="btn btn-success" type="submit" id="search_button">
                                            Filter
                                        </button>
                                    </div>
                                    @if (!empty($date_start) || !empty($date_end))
                                        <div class="text-end">
                                            <a href="{{ route('product.stock.report') }}" class="btn btn-sm btn-danger">
                                                Reset
                                            </a>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Tipe</th>
                                            <th>Quantity</th>
                                            <th>Keterangan</th>
                                            {{-- <th></th> --}}
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
                                                    @if ($item->type == 'in')
                                                        <span class="badge rounded-pill text-bg-secondary">IN
                                                        </span>
                                                    @else
                                                        <span class="badge rounded-pill text-bg-info text-white">OUT
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->qty }}
                                                </td>
                                                <td style="width:45%">
                                                    {{ $item->description }}
                                                </td>
                                                {{-- <td class="text-center">
                                                    @if (Auth::user()->role != 'admin_kepala')
                                                        <form action="{{ route('stock.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger" type="submit"> <i
                                                                    class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td> --}}
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
