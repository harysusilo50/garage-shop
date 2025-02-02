@extends('admin.layout.app')
@section('title', 'Tambah Banner')
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
                            <h5 class="card-title">Create New <span>| Banner</span></h5>
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
                            <form method="POST" action="{{ route('banner.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label fw-bold">Nama
                                        Banner</label>
                                    <div class="col-md-8 col-lg-6">
                                        <input name="name" type="text" class="form-control" id="fullName"
                                            placeholder="Full Name Banner" required>
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
                                    <a href="{{ route('banner.index') }}" class="btn btn-danger col-8 col-md-4 m-2">
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
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
    var uploadCrop = $('#cropie-demo').croppie({
        viewport: {
            width: 300,
            height: 100
        },
        boundary: {
            width: 300,
            height: 300
        },
        showZoomer: true,
    });
    $('#image-dropify').on('change', function() {
        $('#myModal').modal('show');
        var reader = new FileReader();
        reader.onload = function(e) {
            uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function() {
                $('.dropify-render').empty();
                $('.dropify-render').append(
                    '<div class="text-center mt-3"><div class="spinner-grow" style="width: 4rem; height: 4rem;" role="status"><span class="sr-only">Loading...</span></div><h1>Loading...</h1></div>'
                );
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('#crop').on('click', function() {
        var result = uploadCrop.croppie('result', {
            type: 'base64',
            size: {
                width: 900,
                height: 300
            }
        }).then(function(blob) {
            $('#myModal').modal('hide');
            $('.dropify-render').empty();
            $('.dropify-render').append('<img src="' + blob + '">');
            $('#image-dropify-send').val(blob);
        });
    });
</script>

@endsection
