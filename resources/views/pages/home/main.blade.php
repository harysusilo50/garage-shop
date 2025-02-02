@extends('pages.layout.app')
@section('title', 'Home')
@section('css')
    <style>
        /*--------------------------------------------------------------
        # Clients Section
        --------------------------------------------------------------*/
        .clients .swiper-slide img {
            opacity: 0.5;
            transition: 0.3s;
            filter: grayscale(100);
        }

        .clients .swiper-slide img:hover {
            filter: none;
            opacity: 1;
        }

        .clients .swiper-wrapper {
            height: auto;
        }

        .clients .swiper-pagination {
            margin-top: 20px;
            position: relative;
        }

        .clients .swiper-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            opacity: 1;
            background-color: rgba(0, 0, 0, 0.15);
        }

        .clients .swiper-pagination .swiper-pagination-bullet-active {
            background-color: yellow;
        }
    </style>
@endsection
@section('breadcrumb')
    <nav class="bg-white">
        <div class="container px-4">
            <a class="btn btn-outline-light rounded-0 text-black" href="{{ route('home') }}">
                <i class="fa fa-home text-muted" aria-hidden="true"></i></a>
        </div>
    </nav>
@endsection
@section('content')
    <div class="bg-white">
        <div class="container">
            <div class="splide mb-3" id="banner-slider" >
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($banner as $item_banner)
                            <li class="splide__slide px-2">
                                <img class="w-100 rounded-3" src="{{ $item_banner->image_url }}" alt="{{ $item_banner->name }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <h2 class="text-white text-center">Produk Kami</h2>
        <div class="row">
            @foreach ($product as $key => $item)
                <div class="col-6 col-lg-3 col-xxl-2 mt-3">
                    <a class="card text-start border-0 rounded-0 position-relative rounded-top-3"
                        href="{{ route('pages.show.product', $item->slug) }}" style="text-decoration: none"
                        id="card{{ $key }}" onmouseover="card_hover({{ $key }})"
                        onmouseout="card_hout({{ $key }})">

                        <img class="card-img-top rounded-top-3" src="{{ $item->thumbnail_url }}"
                            alt="{{ $item->thumbnail }}">
                        <div class="card-body pb-0 px-2 px-lg-3">
                            <h5 class="card-title align-middle mb-1" style="height: 50px;">
                                {{ $item->title_card }}</h5>
                            <p class="card-text" style="height: 50px">
                                @if ($item->format_discount_price)
                                    <span class="fw-bold d-flex ">
                                        Rp{{ $item->format_discount_price }}
                                    </span>
                                    <small class="text-secondary text-decoration-line-through d-flex">
                                        Rp{{ $item->format_price }}
                                    </small>
                                @else
                                    <span class="fw-bold d-flex ">
                                        Rp{{ $item->format_price }}
                                    </span>
                                @endif

                            </p>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-center mb-2 border-0 rounded-bottom-3 pb-2"
                            id="card_footer{{ $key }}"onmouseover="card_hover({{ $key }})"
                            onmouseout="card_hout({{ $key }})">
                            <a href="{{ route('pages.cart.store', $item->id) }}"
                                class="btn btn-outline-warning btn-sm col-8 mx-1 rounded-0">
                                Tambah
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <section id="brands" class="clients section bg-white py-4">
        <!-- Section Title -->
        <div class="container section-title text-center mb-4">
            <h2>Didukung Oleh Brand Ternama</h2>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "spaceBetween": 40
                    },
                    "480": {
                      "slidesPerView": 3,
                      "spaceBetween": 60
                    },
                    "640": {
                      "slidesPerView": 4,
                      "spaceBetween": 80
                    },
                    "992": {
                      "slidesPerView": 6,
                      "spaceBetween": 120
                    }
                  }
                }
              </script>
                <div class="swiper-wrapper align-items-center">
                    @foreach ($brand as $item)
                        <div class="swiper-slide">
                            <img src="{{ $item->image_url }}" class="img-fluid" alt="{{ $item->name }}"
                                title="{{ $item->name }}">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section>
@endsection
@section('js')
    <script>
        var main = new Splide('#banner-slider', {
            type: 'loop',
            padding: '5rem',
            heightRatio: 0.35,
        }).mount();

        function card_hover(key) {
            $('#card' + key).removeClass('border-0 ');
            $('#card' + key).addClass('border-warning border-1 border-top border-start border-end border-bottom-0');
            $('#card_footer' + key).removeClass('border-0');
            $('#card_footer' + key).addClass('border-warning border-1 border-bottom border-start border-end border-top-0');
        }

        function card_hout(key) {
            $('#card' + key).removeClass('border-warning border-1 border-top border-start border-end border-bottom-0');
            $('#card' + key).addClass('border-0');
            $('#card_footer' + key).removeClass(
                'border-warning border-1 border-bottom border-start border-end border-top-0');
            $('#card_footer' + key).addClass('border-0');
        }
    </script>
@endsection
