@extends('admin.layout.app')
@section('title', 'Edit Produk ' . $product->name)
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
                            <h5 class="card-title">Edit Product <span>| {{ $product->name }}</span></h5>
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
                            <form method="POST" action="{{ route('product.update', $product->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <label for="fullName" class="col-form-label fw-bold">Nama Produk
                                            <span class="text-danger">*</span></label>
                                        <input name="name" type="text" class="form-control" id="fullName"
                                            placeholder="Masukan Nama Produk" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="fullName" class="col-form-label fw-bold">Kategori
                                            <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-control" id="category_id" required>
                                            <option value="" selected>- Pilih Kategori -</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $product->category_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }} </option>
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
                                                <option value="{{ $item->id }}"
                                                    {{ $product->brand_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    {{-- <div class="col-lg-6">
                                        <label for="variant_name" class="col-form-label fw-bold">Variant Produk <small
                                                class="fw-normal text-muted">(opsional)</small>
                                        </label>
                                        <div class="gap-2 mb-2">
                                            @foreach ($product->variant as $variant)
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-secondary disabled text-white">
                                                        {{ $variant->name }}
                                                    </button>
                                                    <button type="button" class="btn btn-secondary text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete_variant_modal{{ $variant->id }}">
                                                        <i class="bi bi-x-circle"></i></button>
                                                </div>
                                                <div class="modal fade" id="delete_variant_modal{{ $variant->id }}"
                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Yakin Hapus Variant ?</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-center">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="delete_product_variant('{{ $variant->id }}')">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Optional: Place to the bottom of scripts -->
                                                <script>
                                                    const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                                </script>
                                            @endforeach
                                        </div>
                                        <input name="variant_name" type="text" class="form-control mb-0"
                                            id="variant_name" placeholder="Tambah Variant Produk">
                                        <small id="variantHelpId" class="form-text text-danger fst-italic m-0 p-0"> Klik
                                            <i class="bi bi-arrow-return-left"></i> untuk menambahkan
                                            variant produk dan <i class="bi bi-backspace-fill"></i> untuk
                                            menghapusnya</small>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <label for="code" class="col-form-label fw-bold">Kode Produk
                                            <span class="text-danger">*</span></label>
                                        <input name="code" type="text" class="form-control" id="code"
                                            placeholder="Masukan Kode Produk" required value="{{ $product->code }}">
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
                                                id="price" required value="{{ $product->price }}">
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
                                                class="form-control border-start-0 ps-0" id="discount_price"
                                                value="{{ $product->discount_price }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="stock" class="col-form-label fw-bold">Stok Produk
                                            <span class="text-danger">*</span></label>
                                        <input name="stock" type="number" class="form-control" id="stock"
                                            placeholder="Masukan Jumlah Stok Produk" required value="{{ $product->stock }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <label for="description_short" class="col-form-label fw-bold">Deskripsi Singkat
                                            Produk
                                            <span class="text-danger">*</span></label>
                                        <div class="form-floating">
                                            <textarea class="form-control" name="description_short" id="description_short" style="height: 100px" required>{{ $product->description_short }}</textarea>
                                            <label for="description_short">Deskripsi Singkat</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="arrival" class="col-form-label fw-bold">Label
                                            <small class="fw-normal text-muted">(opsional)</small>
                                        </label>
                                        <div class="d-lg-flex justify-content-between">
                                            <input type="radio" class="btn-check" name="arrival" id="arrival_no_label"
                                                autocomplete="off" value="no_label" {{ $product->arrival ?? 'checked' }}>
                                            <label class="btn btn-outline-secondary btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_no_label">No Label</label>

                                            <input type="radio" class="btn-check" name="arrival" id="arrival_promo"
                                                autocomplete="off"
                                                value="promo"{{ $product->arrival == 'promo' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_promo">Promo</label>

                                            <input type="radio" class="btn-check" name="arrival"
                                                id="arrival_best_seller" autocomplete="off"
                                                value="best_seller"{{ $product->arrival == 'best_seller' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary btn-sm col-8 mb-1 col-lg-2"
                                                for="arrival_best_seller">Best
                                                Seller</label>

                                            <input type="radio" class="btn-check" name="arrival"
                                                id="arrival_produk_baru" autocomplete="off"
                                                value="produk_baru"{{ $product->arrival == 'produk_baru' ? 'checked' : '' }}>
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
                                        <div class="form-group" id="container_upload_thumbnail">
                                            @include('components.upload_image.html')
                                            <textarea id="image-dropify-send" class="d-none" name="image"></textarea>
                                        </div>
                                        <div class="text-center" id="container_thumbnail">
                                            <img class="w-50" src="{{ $product->thumbnail_url }}"
                                                alt="{{ $product->thumbnail_url }}">
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-secondary col-8 mt-3" id="btn_change">
                                                Ubah <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="gallery" class="col-form-label fw-bold">
                                        Gallery Produk
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-12 mb-2">
                                        <div class="splide" role="group" aria-label="Splide Basic HTML Example"
                                            id="album">
                                            <div class="splide__track bg-light py-2">
                                                <ul class="splide__list" style="height: 240px">
                                                    @foreach ($product->photo as $photos)
                                                        <li class="splide__slide ">
                                                            <img class="mx-2" style="height:200px"
                                                                src="{{ $photos->photo_url }}">
                                                            <div class="col-8 m-auto">
                                                                <button
                                                                    class="btn btn-danger btn-sm col-12 {{ count($product->photo) == 1 ? 'disabled' : '' }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal_photos_delete{{ $photos->id }}">
                                                                    Hapus <i class="bi bi-trash3"></i>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @foreach ($product->photo as $photos)
                                            <div class="modal fade" id="modal_photos_delete{{ $photos->id }}"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Yakin hapus gambar?</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body d-flex justify-content-center">
                                                            <img class="mx-2" style="height:200px"
                                                                src="{{ $photos->photo_url }}">
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="delete_product_pic_gallery('{{ $photos->id }}')">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-end mb-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#gallery_modal" type="button">
                                            Tambah Gambar
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <div class="splide" role="group" aria-label="Splide Basic HTML Example"
                                            id="container_splide_gallery">
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
        var splide = new Splide('#container_splide_gallery', {
            focus: 0,
            drag: 'free',
            autoWidth: true,
        });

        splide.mount();

        var album = new Splide('#album', {
            focus: 0,
            drag: 'free',
            autoWidth: true,
        });

        album.mount();
    </script>

    {{-- CK EDITOR DESC LONG --}}
    <script>
        CKEDITOR.replace('description_long');
        var test = `{!! $product->description_long !!}`;
        $(document).ready(function() {
            CKEDITOR.instances['description_long'].setData(test)
        });
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
    {{-- change thumbnail --}}
    <script>
        $(document).ready(function() {
            $('#container_upload_thumbnail').hide();

            $('#btn_change').click(function(e) {
                e.preventDefault();
                $('#container_upload_thumbnail').toggle('slow');
                $('#container_thumbnail').toggle('slow');
            });
        });
    </script>
    {{-- delete product pic and variant gallery --}}
    <script>
        function delete_product_pic_gallery(id) {
            var url = "{{ url('/admin/product-gallery/delete') }}" + "/" + id;
            $.post(url, {
                    _token: "{{ csrf_token() }}"
                },
                function(data, textStatus, jqXHR) {
                    location.reload()
                },
                "JSON"
            );
            location.reload()
        }

        function delete_product_variant(id) {
            var url = "{{ url('/admin/product-variant/delete') }}" + "/" + id;
            $.post(url, {
                    _token: "{{ csrf_token() }}"
                },
                function(data, textStatus, jqXHR) {
                    location.reload()
                },
                "JSON"
            );
            location.reload()
        }
    </script>
@endsection
