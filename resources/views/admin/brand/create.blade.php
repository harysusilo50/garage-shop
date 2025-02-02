@extends('admin.layout.app')
@section('title', 'Tambah Brand')
@section('css')
    <style>
        .dropify-wrapper .dropify-message .file-icon {
            font-size: 24px !important;
        }
    </style>
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">Create New <span>| Brand</span></h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            @endif
                            <form method="POST" action="{{ route('brand.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label fw-bold">Nama
                                        Brand</label>
                                    <div class="col-md-8 col-lg-6">
                                        <input name="name" type="text" class="form-control" id="fullName"
                                            placeholder="Full Name brand" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="image-dropify" class="col-md-4 col-lg-3 col-form-label fw-bold"
                                        style="font-weight: 500">Upload
                                        Photos</label>
                                    <div class="form-group col-12 col-lg-4">
                                        @include('components.upload_image.html')
                                    </div>
                                    <textarea id="image-dropify-send" class="d-none" name="image" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary col-8 col-md-4 m-2">Save</button>
                                    <a href="{{ route('brand.index') }}" class="btn btn-danger col-8 col-md-4 m-2">
                                        Cancel</a>
                                </div>
                            </form><!-- End Profile Edit Form -->
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection
@section('js')
    @include('components.upload_image.js')
@endsection
