@extends('admin.layout.app')
@section('title', 'Kelola Banner')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">List <span>| Banner</span></h5>
                            <div class="d-lg-flex justify-content-lg-between mb-3 d-block">
                                <div class="my-2">
                                    @if (Auth::user()->role != 'admin_kepala')
                                        <a href="{{ route('banner.create') }}" class="btn btn-primary">
                                            Tambah Data
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </a>
                                    @endif
                                </div>
                                <form action="{{ route('banner.index') }}" method="GET">
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control" placeholder="Search Banner" name="search"
                                            aria-label="Search Banner" value="{{ $search ?? '' }}"
                                            aria-describedby="search_button" />
                                        <button class="btn btn-success" type="submit" id="search_button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    @if (!empty($search))
                                        <div class="text-end">
                                            <a href="{{ route('banner.index') }}" class="btn btn-sm btn-danger">
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
                                            <th>Gambar</th>
                                            <th>Banner</th>
                                            <th>Slug</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center" style="width:5%">
                                                    {{ $data->firstItem() + $loop->index }}</td>
                                                <td class="text-center" style="width: 20%">
                                                    <img class="w-75" src="{{ $item->image_url }}">
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    {{ $item->slug }}
                                                </td>
                                                <td class="text-center" style="width: 10%">
                                                    @if (Auth::user()->role != 'admin_kepala')
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('banner.edit', $item->id) }}">
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
                                                                    <form action="{{ route('banner.destroy', $item->id) }}"
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
