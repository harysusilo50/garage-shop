@extends('admin.layout.app')
@section('title', 'Kelola Stock Product')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">List <span>| Stock Product</span></h5>
                            <div class="d-lg-flex justify-content-lg-between mb-3 d-block">
                                <div class="my-2">
                                    <a href="{{ route('product.report') }}" class="btn btn-danger" target="_blank">Export
                                        <i class="bi bi-file-pdf-fill"></i></a>
                                </div>
                                <form action="{{ route('stock.index') }}" method="GET">
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control" placeholder="Search Product"
                                            name="search" aria-label="Search Product" value="{{ $search ?? '' }}"
                                            aria-describedby="search_button" />
                                        <button class="btn btn-success" type="submit" id="search_button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    @if (!empty($search))
                                        <div class="text-end">
                                            <a href="{{ route('stock.index') }}" class="btn btn-sm btn-danger">
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
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Thumbnail</th>
                                            <th colspan="3">Stok</th>
                                            <th rowspan="2">Nama Produk</th>
                                            <th rowspan="2">Aksi</th>
                                        </tr>
                                        <tr class="text-center align-middle">
                                            <th>Masuk</th>
                                            <th>Keluar</th>
                                            <th>Sisa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center" style="width:5%">
                                                    {{ $data->firstItem() + $loop->index }}</td>
                                                <td class="text-center" style="width: 20%">
                                                    <img class="w-75" src="{{ $item->thumbnail_url }}">
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->stock_in }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->stock_out }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->stock }}
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td class="text-center" style="width: 10%">
                                                    @if (Auth::user()->role != 'admin_kepala')
                                                        <a class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modal_stock{{ $item->id }}">
                                                            <i class="bi bi-plus-circle fs-4"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modal_stock{{ $item->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tambah Stock {{ $item->name }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('stock.add', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="container-fluid">
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Jumlah
                                                                                Barang</label>
                                                                            <input type="number" class="form-control"
                                                                                name="qty" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Total
                                                                                Harga</label>
                                                                            <input type="number" class="form-control"
                                                                                name="amount" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for=""
                                                                                class="form-label">Tanggal</label>
                                                                            <input type="date" class="form-control"
                                                                                name="date" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for=""
                                                                                class="form-label">Catatan</label>
                                                                            <textarea class="form-control" name="notes" rows="3" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
