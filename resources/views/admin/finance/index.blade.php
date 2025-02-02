@extends('admin.layout.app')
@section('title', 'Laporan Keuangan')
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
                            Pemasukan
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-graph-down-arrow"></i>
                            </div>
                            <div class="ps-3">
                                <h4 class="fw-bold">Rp{{ number_format($pemasukan, 0, ',', '.') }}</h4>
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
                            Pengeluaran
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center text-white"
                                style="background-color:#dc35468f">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="ps-3 ">
                                <h4 class="fw-bold text-danger">Rp{{ number_format($pengeluaran, 0, ',', '.') }}</h4>
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
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Profit
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3 ">
                                <h4 class="fw-bold {{ $keuntungan < 0 ? 'text-danger' : '' }}">
                                    Rp{{ number_format($keuntungan, 0, ',', '.') }}</h4>
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
                                <h5 class="card-title">Financial Report</span></h5>
                            </div>
                            <div class="d-lg-flex justify-content-lg-end mb-3 d-block">
                                <form action="{{ route('finance.index') }}" method="GET">
                                    <div class="my-2 d-flex justify-content-between">
                                        <input type="date" class="form-control" name="date_start"
                                            value="{{ $date_start ?? '' }}" />
                                        <input type="date" class="form-control" name="date_end"
                                            value="{{ $date_end ?? '' }}" />
                                    </div>
                                    <div class="text-end mb-2">
                                        <a target="_blank"
                                            href="{{ route('finance.report', ['date_start' => $date_start ?? '', 'date_end' => $date_end ?? '']) }}"
                                            class="btn btn-primary">
                                            Report <i class="bi bi-download"></i>
                                        </a>
                                        <button class="btn btn-success" type="submit" id="search_button">
                                            Filter
                                        </button>
                                    </div>
                                    @if (!empty($date_start) || !empty($date_end))
                                        <div class="text-end">
                                            <a href="{{ route('finance.index') }}" class="btn btn-sm btn-danger">
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
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            {{-- <th></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr
                                                style="  {{ $item->type != 'in' ? '' : 'background-color:#dc35468f;color:white' }}">
                                                <td class="text-center" style="width:5%">
                                                    {{ $data->firstItem() + $loop->index }}</td>
                                                <td class="text-center">
                                                    {{ $item->format_date }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->type != 'in')
                                                        <span class="badge rounded-pill text-bg-info text-white">IN
                                                            <i class="bi bi-arrow-down-left-square"></i></span>
                                                    @else
                                                        <span class="badge rounded-pill text-bg-danger">OUT
                                                            <i class="bi bi-arrow-up-right-square-fill"></i></span>
                                                    @endif
                                                </td>
                                                <td class="{{ $item->type != 'in' ? 'text-start' : 'text-end' }}">
                                                    Rp {{ $item->format_amount }}
                                                </td>
                                                <td style="width:45%">
                                                    {{ $item->description }}
                                                </td>
                                                {{-- <td class="text-center">
                                                    @if (Auth::user()->role != 'admin_kepala')
                                                        <form action="{{ route('finance.destroy', $item->id) }}"
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
