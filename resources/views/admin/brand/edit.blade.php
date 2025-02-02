@extends('admin.layout.app')
@section('title', 'Edit Data Brand ' . $data->name)
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
                            <h5 class="card-title">Edit Data <span>| {{ $data->name }}</span></h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}
                                                <button type="button" class="close" data-bs-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            @endif
                            <form method="POST" action="{{ route('brand.update', $data->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label fw-bold">Nama
                                        Brand</label>
                                    <div class="col-md-8 col-lg-6">
                                        <input name="name" type="text" class="form-control" id="fullName"
                                            placeholder="Full Name brand" value="{{ $data->name }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="image-dropify" class="col-md-4 col-lg-3 col-form-label fw-bold"
                                        style="font-weight: 500">Upload
                                        Photos</label>
                                    <div class="form-group col-12 col-lg-4">
                                        <div id="container_upload">
                                            @include('components.upload_image.html')
                                            <textarea id="image-dropify-send" class="d-none" name="image"></textarea>
                                        </div>
                                        <div id="container_photos">
                                            <img class="w-75" src="{{ $data->image_url }}">
                                        </div>
                                        <button class="btn btn-secondary mt-3" id="btn_change">
                                            Change <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </div>
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

    <script>
        $(document).ready(function() {
            $('#container_upload').hide();

            $('#btn_change').click(function(e) {
                e.preventDefault();
                $('#container_upload').toggle('slow');
                $('#container_photos').toggle('slow');
            });
        });
    </script>
@endsection
