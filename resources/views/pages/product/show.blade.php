@extends('pages.layout.app')
@section('title', $product->name)
@section('breadcrumb')
    <nav class="bg-white ">
        <div class="container px-4 ">
            <a class="btn btn-outline-light rounded-0 text-muted" href="{{ route('home') }}">
                <i class="fa fa-home" aria-hidden="true"></i></a>
            <span class="bg-white rounded-0 align-middle px-2">
                <small>
                    <i class="fa fa-chevron-right text-muted" aria-hidden="true"></i>
                </small>
            </span>
            <a class="btn btn-outline-light rounded-0 fw-bold text-muted"
                href="{{ route('pages.show.category', ['name' => $product->category->slug]) }}">
                <small>
                    <i class="fa {{ $product->category->icon }}" aria-hidden="true"></i> {{ $product->category->name }}
                </small>
            </a>
            <span class="bg-white rounded-0 align-middle px-2">
                <small>
                    <i class="fa fa-chevron-right text-muted" aria-hidden="true"></i>
                </small>
            </span>
            <a class="btn btn-outline-light active rounded-0 fw-bold text-muted" href="{{ request()->fullUrl() }}">
                <small>
                    <i class="fa fa-th-large" aria-hidden="true"></i>
                    {{ $product->title_breadcumb }}
                </small>
            </a>
        </div>
    </nav>
@endsection
@section('content')
    <div class="container mt-2">
        <div class="card border-0 rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3 position-relative">
                        <div class="position-absolute top-0 end-0 z-3">
                        </div>
                        <div class="splide mb-3" id="main-slider">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide">
                                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}">
                                    </li>
                                    @foreach ($product->photo as $item_photo)
                                        <li class="splide__slide">
                                            <img src="{{ $item_photo->photo_url }}" alt="{{ $item_photo->photo_url }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="splide" id="thumbnail-slider">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide">
                                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}">
                                    </li>
                                    @foreach ($product->photo as $item_photo)
                                        <li class="splide__slide">
                                            <img src="{{ $item_photo->photo_url }}" alt="{{ $item_photo->photo_url }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 mb-3 px-lg-5">
                        <h2 class="card-title fw-bold">
                            {{ $product->name }}
                        </h2>
                        <div class="d-flex">
                            <h4 class="me-2">
                                @switch($product->arrival)
                                    @case('promo')
                                        <div class="badge bg-warning fw-medium text-white px-2 text-wrap rounded-0 mt-2">
                                            <small>PROMO</small>
                                        </div>
                                    @break

                                    @case('best_seller')
                                        <div class="badge bg-primary fw-medium text-white px-2 text-wrap rounded-0 mt-2">
                                            <small>BEST SELLER</small>
                                        </div>
                                    @break

                                    @case('produk_baru')
                                        <div class="badge bg-success fw-medium text-white px-2 text-wrap rounded-0 mt-2">
                                            <small>NEW</small>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            </h4>
                            @if ($product->format_discount_price)
                                <h3 class="fw-bold text-danger me-2 align-middle">
                                    Rp{{ $product->format_discount_price }}
                                </h3>
                                <p class="text-secondary text-decoration-line-through align-middle">
                                    Rp{{ $product->format_price }}
                                </p>
                            @else
                                <h3 class="fw-bold d-flex align-middle">
                                    Rp{{ $product->format_price }}
                                </h3>
                            @endif
                        </div>
                        <hr class="border-1 border-bottom border-secondary-subtle">
                        <p class="card-text fw-bold mb-2">
                            Deskripsi Singkat:
                        </p>
                        <div class="card-text mb-2">
                            {!! $product->description_short !!} <a href="#" data-bs-toggle="modal"
                                data-bs-target="#modal_desc_long">Lihat Deskripsi Lengkap</a>
                            <div class="modal fade" id="modal_desc_long" tabindex="-1" role="dialog"
                                aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! $product->description_long !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="border-1 border-bottom border-secondary-subtle">
                        <p class="card-text fw-bold mb-1">
                            Kategori :
                            <a href="" class="text-decoration-none">
                                <i class="fa {{ $product->category->icon }}"
                                    aria-hidden="true"></i>{{ $product->category->name }}
                            </a>
                        </p>
                        <p class="card-text fw-bold">
                            Brand :
                            <a href="" class="text-decoration-none">
                                {{ $product->brand->name }}
                            </a>
                        </p>
                        <hr class="border-1 border-bottom border-secondary-subtle">
                        <p class="card-text fw-bold">
                            Stock :
                            <span>{{ $product->stock }}</span>
                        </p>
                        <hr class="border-1 border-bottom border-secondary-subtle">
                        <form class="" action="{{ route('pages.checkout.index') }}" method="POST">
                            {{-- @if ($product->variant)
                                <p class="card-text fw-bold mb-2">
                                    Variant :
                                </p>
                                <div class="d-flex">
                                    @foreach ($product->variant as $key => $variant)
                                        <input type="radio" class="btn-check" name="variant_id"
                                            id="variant{{ $variant->id }}" value="{{ $variant->id }}"
                                            {{ $key == 0 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary btn-sm fs-6 me-2"
                                            for="variant{{ $variant->id }}">{{ $variant->name }}</label>
                                    @endforeach
                                </div>
                            @endif --}}
                            {{-- <hr class="border-1 border-bottom border-secondary-subtle"> --}}
                            <p class="card-text fw-bold mb-2">
                                Atur Jumlah :
                            </p>
                            @csrf
                            <div class="col-5 mb-3 m-auto">
                                <div class="input-group">
                                    <button class="btn btn-sm input-group-text btn-light" id="btn_qty_minus">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    <input type="number" name="qty" id="qty"
                                        class="form-control text-center bg-light-subtle border-0 fw-bold px-0 mx-0"
                                        value="1" min="1" readonly>
                                    <button class="btn btn-sm input-group-text btn-light" id="btn_qty_plus">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="number" class="d-none" name="product_id" value="{{ $product->id }}"
                                required>
                            <div class="d-lg-flex text-center justify-content-lg-around">
                                <a href="{{ route('pages.cart.store', $product->id) }}"
                                    class="btn btn-outline-warning btn-lg col-12 col-lg-5 mb-2">Tambah ke
                                    Keranjang
                                </a>
                                <button class="btn btn-primary btn-lg col-12 col-lg-5 mb-2" type="submit">
                                    Beli Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var main = new Splide('#main-slider', {
            type: 'fade',
            heightRatio: 1,
            arrows: false,
            cover: true,
        });

        var thumbnails = new Splide('#thumbnail-slider', {
            rewind: true,
            fixedWidth: 100,
            fixedHeight: 100,
            isNavigation: true,
            gap: 10,
            focus: 'center',
            pagination: false,
            cover: true,
            dragMinThreshold: {
                mouse: 4,
                touch: 10,
            },
            breakpoints: {
                640: {
                    fixedWidth: 50,
                    fixedHeight: 50,
                },
            },
        });

        main.sync(thumbnails);
        main.mount();
        thumbnails.mount();
    </script>
    <script>
        $('#btn_qty_minus').click(function(e) {
            e.preventDefault();
            var qty = $('#qty').val();
            qty--;
            qty = qty < 1 ? 1 : qty;
            $('#qty').val(qty);
        });
        $('#btn_qty_plus').click(function(e) {
            e.preventDefault();
            var qty = $('#qty').val();
            qty++;
            $('#qty').val(qty);
        });
    </script>
@endsection
