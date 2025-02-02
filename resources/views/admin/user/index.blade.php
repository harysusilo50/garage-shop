@extends('admin.layout.app')
@section('title', 'Kelola User')
@section('css')
    <link href="{{ asset('pages/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">List <span>| User</span></h5>
                            <div class="d-lg-flex justify-content-lg-between mb-3 d-block">
                                <div class="my-2">
                                    @if (Auth::user()->role != 'admin_kepala')
                                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-2">
                                            Tambah Data
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </a>
                                    @endif
                                    <br>
                                    <a href="{{ route('admin.user.report') }}" class="btn btn-danger" target="_blank">Export
                                        <i class="bi bi-file-pdf-fill"></i></a>
                                </div>
                                <form action="{{ route('admin.user.index') }}" method="GET">
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control" placeholder="Search User" name="search"
                                            aria-label="Search User" value="{{ $search ?? '' }}"
                                            aria-describedby="search_button" />
                                        <button class="btn btn-success" type="submit" id="search_button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    @if (!empty($search))
                                        <div class="text-end">
                                            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-danger">
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Kelas</th>
                                            <th>No Telp</th>
                                            <th>Role</th>
                                            <th>Verifikasi</th>
                                            @if (Auth::user()->role != 'admin_kepala')
                                                <th>Status</th>
                                            @endif
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center" style="width:5%">
                                                    {{ $data->firstItem() + $loop->index }}</td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    {{ $item->email }}
                                                </td>
                                                <td>
                                                    {{ $item->address }}
                                                </td>
                                                <td>
                                                    +62{{ $item->phone }}
                                                </td>
                                                <td>
                                                    @switch($item->role)
                                                        @case('superadmin')
                                                            <span class="badge rounded-pill text-bg-warning">Superadmin</span>
                                                        @break

                                                        @case('bendahara')
                                                            <span class="badge rounded-pill text-bg-danger">Bendahara</span>
                                                        @break

                                                        @case('warehouse')
                                                            <span class="badge rounded-pill text-bg-secondary">Warehouse</span>
                                                        @break

                                                        @case('admin_toko')
                                                            <span class="badge rounded-pill text-bg-success">Admin Toko</span>
                                                        @break

                                                        @case('admin_kepala')
                                                            <span class="badge rounded-pill text-bg-info">Admin Kepala</span>
                                                        @break

                                                        @default
                                                            <span
                                                                class="badge rounded-pill text-bg-primary">{{ $item->role }}</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    {{ $item->format_email_verified_at ?? '-' }}
                                                </td>
                                                @if (Auth::user()->role != 'admin_kepala')
                                                    <td class="text-center">
                                                        <!-- Button trigger modal -->
                                                        @if ($item->status == 1)
                                                            <button type="button"
                                                                class="btn btn-light btn-sm rounded fw-bold col-12 d-flex flex-column justify-content-center text-center"
                                                                style="font-size: 10px" data-bs-toggle="modal"
                                                                data-bs-target="#model_delete{{ $item->id }}">
                                                                Aktif
                                                                <div class="form-check form-switch mx-auto">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" disabled checked>
                                                                </div>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-light btn-sm rounded fw-bold col-12 d-flex flex-column justify-content-center text-center"
                                                                style="font-size: 10px" data-bs-toggle="modal"
                                                                data-bs-target="#model_delete{{ $item->id }}">
                                                                Non Aktif
                                                                <div class="form-check form-switch mx-auto">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" disabled>
                                                                </div>
                                                            </button>
                                                        @endif
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="model_delete{{ $item->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ route('admin.user.destroy', $item->id) }}"
                                                                        method="POST">
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
                                                                            Apakah anda yakin ingin mengubah data ini?
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer d-flex justify-content-center border-0">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button
                                                                                type="submit"class="btn btn-danger">Ubah</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td class="text-center" style="width: 10%">
                                                    <a class="btn btn-primary btn-sm" target="_blank"
                                                        href="{{ route('pages.profile.index', $item->hash_id) }}">
                                                        <i class="bi bi-search"></i>
                                                    </a>
                                                    @if (Auth::user()->role != 'admin_kepala')
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('admin.user.edit', $item->id) }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
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
