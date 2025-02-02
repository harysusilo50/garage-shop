@extends('admin.layout.app')
@section('title', 'Tambah Produk')
@section('css')
    <style>
        .dropify-wrapper .dropify-message .file-icon {
            font-size: 24px !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/selectize-bootstrap4-theme@2.0.2/dist/css/selectize.bootstrap4.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">Create New <span>| Product</span></h5>
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
                            <form method="POST" action="{{ route('product.store') }}">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <label for="fullName" class="col-form-label fw-bold">Nama Produk
                                            <span class="text-danger">*</span></label>
                                        <input name="name" type="text" class="form-control" id="fullName"
                                            placeholder="Masukan Nama Produk" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="fullName" class="col-form-label fw-bold">Kategori
                                            <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-control" id="category_id" required>
                                            <option value="" selected>- Pilih Kategori -</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="fullName" class="col-form-label fw-bold">Brand
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="brand_id" class="form-control" id="brand_id" required>
                                            <option value="" selected>- Pilih Brand -</option>
                                            @foreach ($brand as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    {{-- <div class="col-lg-6">
                                        <label for="variant_name" class="col-form-label fw-bold">Variant Produk <small
                                                class="fw-normal text-muted">(opsional)</small>
                                        </label>
                                        <input name="variant_name" type="text" class="form-control mb-0"
                                            id="variant_name" placeholder="Masukan Variant Produk">
                                        <small id="variantHelpId" class="form-text text-danger fst-italic m-0 p-0"> Klik
                                            <i class="bi bi-arrow-return-left"></i> untuk menambahkan
                                            variant produk dan <i class="bi bi-backspace-fill"></i> untuk
                                            menghapusnya</small>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <label for="code" class="col-form-label fw-bold">Kode Produk
                                            <span class="text-danger">*</span></label>
                                        <input name="code" type="text" class="form-control" id="code"
                                            placeholder="Masukan Kode Produk" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3">
                                        <label for="price" class="col-form-label fw-bold">Harga Produk
                                            <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                Rp
                                            </span>
                                            <input name="price" type="number" class="form-control border-start-0 ps-0"
                                                id="price" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="discount_price" class="col-form-label fw-bold">Harga Diskon
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                Rp
                                            </span>
                                            <input name="discount_price" type="number"
                                                class="form-control border-start-0 ps-0" id="discount_price">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="modal_price" class="col-form-label fw-bold">Total Harga Modal
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                Rp
                                            </span>
                                            <input name="modal_price" type="number"
                                                class="form-control border-start-0 ps-0" id="modal_price">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="stock" class="col-form-label fw-bold">Stok Produk
                                            <span class="text-danger">*</span></label>
                                        <input name="stock" type="number" class="form-control" id="stock"
                                            placeholder="Masukan Jumlah Stok Produk" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <label for="description_short" class="col-form-label fw-bold">Deskripsi Singkat
                                            Produk
                                            <span class="text-danger">*</span></label>
                                        <div class="form-floating">
                                            <textarea class="form-control" name="description_short" id="description_short" style="height: 100px" required></textarea>
                                            <label for="description_short">Deskripsi Singkat</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="arrival" class="col-form-label fw-bold">Label
                                            <small class="fw-normal text-muted">(opsional)</small>
                                        </label>
                                        <div class="d-lg-flex justify-content-between">
                                            <input type="radio" class="btn-check" name="arrival" id="arrival_no_label"
                                                autocomplete="off" value="no_label" checked>
                                            <label class="btn btn-outline-secondary btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_no_label">No Label</label>

                                            <input type="radio" class="btn-check" name="arrival" id="arrival_promo"
                                                autocomplete="off" value="promo">
                                            <label class="btn btn-outline-warning btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_promo">Promo</label>

                                            <input type="radio" class="btn-check" name="arrival"
                                                id="arrival_best_seller" autocomplete="off" value="best_seller">
                                            <label class="btn btn-outline-primary btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_best_seller">Best
                                                Seller</label>

                                            <input type="radio" class="btn-check" name="arrival"
                                                id="arrival_produk_baru" autocomplete="off" value="produk_baru">
                                            <label class="btn btn-outline-success btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_produk_baru">Produk Baru</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="description_short" class="col-form-label fw-bold">
                                                Deskripsi Lengkap Produk
                                                <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description_long" id="description_long" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="image-dropify" class="col-form-label fw-bold">Upload Thumbnail
                                            Produk <span class="text-danger">*</span></label></label>
                                        <br>
                                        <small id="thumbnailHelpId"
                                            class="form-text text-danger fst-italic m-0 p-0">Thumbnail adalah gambar
                                            pertama produk yang akan ditampilkan</small>
                                        <div class="form-group">
                                            @include('components.upload_image.html')
                                        </div>
                                        <textarea id="image-dropify-send" class="d-none" name="image" required></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="gallery" class="col-form-label fw-bold">
                                        Gallery Produk
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="text-end mb-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#gallery_modal" type="button">
                                            Tambah Gambar
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                                            <div class="splide__track bg-light py-2">
                                                <ul class="splide__list" id="gallery_container" style="height: 240px">

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary col-8 col-md-4 m-2">Save</button>
                                    <a href="{{ route('product.index') }}" class="btn btn-danger col-8 col-md-4 m-2">
                                        Cancel</a>
                                </div>
                            </form><!-- End Profile Edit Form -->
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
    <div class="modal fade" id="gallery_modal" tabindex="-1" role="dialog" aria-labelledby="gallery_modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Pilih Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="gallery-input" type="file" class="btn btn-primary" accept="image/*"
                        data-max-file-size="2M">
                    <p class="text-danger text-small font-weight-bold m-0">*Ukuran gambar max 2MB</p>
                    <div class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                        id="myModalgallery" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white text-center">
                                    <h5 class="modal-title ">Sesuaikan Gambar <i class="fas fa-crop-alt"></i></h5>
                                </div>
                                <div class="modal-body">
                                    <div id="select-img-gallery"></div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" id="crop-gallery"
                                        class="btn btn-success col-6">Potong</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="container_modal_detail">

    </div>
@endsection
@section('js')
    @include('components.upload_image.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#category_id").selectize();
        $("#brand_id").selectize();
        $("#variant_name").selectize({
            delimiter: ",",
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input,
                };
            }
        });
    </script>

    {{-- SPLIDE JS --}}
    <script>
        var splide = new Splide('.splide', {
            focus: 0,
            drag: 'free',
            autoWidth: true,
        });

        splide.mount();
    </script>

    {{-- CK EDITOR DESC LONG --}}
    <script>
        CKEDITOR.replace('description_long');
    </script>

    {{-- Cropie Gallery --}}
    <script>
        var uploadCropgallery = $('#select-img-gallery').croppie({
            viewport: {
                width: 200,
                height: 200
            },
            boundary: {
                width: 300,
                height: 300
            },
            showZoomer: true,
        });
        $('#gallery-input').on('change', function() {
            $('#myModalgallery').modal('show');
            var readergallery = new FileReader();
            readergallery.onload = function(e) {
                uploadCropgallery.croppie('bind', {
                    url: e.target.result
                }).then(function() {
                    console.log('Oke');
                });
            }
            readergallery.readAsDataURL(this.files[0]);
        });
        $('#crop-gallery').on('click', function() {
            var resultgallery = uploadCropgallery.croppie('result', {
                type: 'base64',
                size: {
                    width: 500,
                    height: 500
                }
            }).then(function(blobgallery) {
                $('#gallery-input').val('');
                $('#myModalgallery').modal('hide');
                $('#gallery_modal').modal('hide');
                var random = Math.floor(Math.random() * Date.now()).toString(36);
                var id = random.replace(/[0-9]/g, '');
                splide.add(
                    `<li class="splide__slide ${id}" onmouseover="mouseover_gallery('${id}')" onmouseout="mouseout_gallery('${id}')">
                         <div class="position-relative">
                            <img class="mx-2" style="height:200px" src="${blobgallery}"  id="img_${id}">
                             <div class="d-none justify-content-center position-absolute top-50 start-50 translate-middle" id="control_${id}">
                                <button class="btn btn-sm btn-secondary mx-1" type="button" data-bs-toggle="modal" data-bs-target="#modal_detail_${id}">
                                    <i class="bi bi-eye-fill"></i> Detail</button>
                                <button class="btn btn-sm btn-danger mx-1" type="button" onclick="remove_gallery('${id}')">
                                    <i class="bi bi-trash-fill"></i> Delete</button>
                            </div>
                        </div>
                        <textarea class="d-none" name="image_gallery[]">${blobgallery}</textarea>
                    </li>
                    `
                );
                splide.refresh();
                $('#container_modal_detail').append(`
                    <div class="modal fade" id="modal_detail_${id}" tabindex="-1"
                        role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center">
                                    <img class="mx-2 w-100"src="${blobgallery}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });
        });

        function remove_gallery(id) {
            splide.remove('.' + id);
            splide.refresh();
            $('#modal_detail_' + id).remove();
        }

        function mouseover_gallery(id) {
            $('.' + id).addClass('bg-dark');
            $('#control_' + id).removeClass('d-none');
            $('#img_' + id).addClass('opacity-25');
            $('#control_' + id).addClass('d-flex');
        }

        function mouseout_gallery(id) {
            $('.' + id).removeClass('bg-dark');
            $('#control_' + id).addClass('d-none');
            $('#control_' + id).removeClass('d-flex');
            $('#img_' + id).removeClass('opacity-25');
        }
    </script>
@endsection
