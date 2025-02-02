@extends('admin.layout.app')
@section('title', 'Kelola Product')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">List <span>| Product</span></h5>
                            <div class="d-lg-flex justify-content-lg-between mb-3 d-block">
                                <div class="my-2">
                                    @if (Auth::user()->role != 'admin_kepala')
                                        <a href="{{ route('product.create') }}" class="btn btn-primary">
                                            Tambah Data
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </a>
                                    @endif
                                </div>
                                <form action="{{ route('product.index') }}" method="GET">
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
                                            <a href="{{ route('product.index') }}" class="btn btn-sm btn-danger">
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
                                            <th>Thumbnail</th>
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
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
                                                <td>
                                                    {{ $item->code }}
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->stock }}
                                                </td>
                                                <td>
                                                    Rp. {{ $item->format_price }}
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-light btn-sm"
                                                        onclick="is_active({{ $item->id }})">
                                                        <i class="bi fs-5 text-primary {{ $item->is_active == 'yes' ? 'bi-toggle-on' : 'bi-toggle-off' }}"
                                                            id="toggle{{ $item->id }}"></i>
                                                    </button>
                                                    <br>
                                                    @if ($item->is_active == 'yes')
                                                        <span class="badge bg-success mb-2"
                                                            id="status_active{{ $item->id }}">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger mb-2"
                                                            id="status_active{{ $item->id }}">Non
                                                            Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center" style="width: 10%">
                                                    @if (Auth::user()->role != 'admin_kepala')
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('product.edit', $item->id) }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#model_delete{{ $item->id }}">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="model_delete{{ $item->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ route('product.destroy', $item->id) }}"
                                                                        method="POST">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <div class="modal-header border-0">
                                                                            <h5 class="modal-title">Peringatan!</h5>
                                                                            <button type="button"
                                                                                class="btn btn-close bg-light"
                                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true"></span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body border-0">
                                                                            Apakah anda yakin ingin menghapus data ini?
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer d-flex justify-content-center border-0">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button
                                                                                type="submit"class="btn btn-danger">Hapus</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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
@section('js')
    <script>
        function is_active(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('admin/product-active-status') }}" + "/" + id,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: "JSON",
            }).done(function(data, textStatus) {
                if (data.is_active == 'no') {
                    $('#status_active' + id).removeClass('bg-success');
                    $('#status_active' + id).addClass('bg-danger');

                    $('#toggle' + id).removeClass('bi-toggle-on');
                    $('#toggle' + id).addClass('bi-toggle-off');

                    $('#status_active' + id).text('Non Aktif');
                } else {
                    $('#status_active' + id).removeClass('bg-danger');
                    $('#status_active' + id).addClass('bg-success');

                    $('#toggle' + id).removeClass('bi-toggle-off');
                    $('#toggle' + id).addClass('bi-toggle-on');

                    $('#status_active' + id).text('Aktif');
                }

            }).fail(function(textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            }).always(function() {

            });
        }
    </script>
@endsection
