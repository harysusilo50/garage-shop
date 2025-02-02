@extends('pages.layout.app')
@section('title', 'Search : ' . $search)
@section('breadcrumb')
    <nav class="bg-white">
        <div class="container px-4">
            <a class="btn btn-outline-light rounded-0 text-muted" href="{{ route('home') }}">
                <i class="fa fa-home" aria-hidden="true"></i></a>
            <span class="bg-white rounded-0 align-middle px-2">
                <small>
                    <i class="fa fa-chevron-right text-muted" aria-hidden="true"></i>
                </small>
            </span>
            <a class="btn btn-outline-light active rounded-0 fw-bold text-muted" href="{{ request()->fullUrl() }}">
                <small>
                    <i class="fa fa-search" aria-hidden="true"></i> {{ $title }}
                </small></a>
        </div>
    </nav>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @foreach ($product as $key => $item)
                <div class="col-6 col-lg-3 col-xxl-2 mt-3">
                    <a class="card text-start border-0 rounded-0 position-relative"
                        href="{{ route('pages.show.product', $item->slug) }}" style="text-decoration: none"
                        id="card{{ $key }}" onmouseover="card_hover({{ $key }})"
                        onmouseout="card_hout({{ $key }})">

                        @switch($item->arrival)
                            @case('promo')
                                <div
                                    class="badge position-absolute top-0 end-0 bg-warning fw-bold text-white px-2 text-wrap rounded-0 mt-2">
                                    <small>PROMO</small>
                                </div>
                            @break

                            @case('best_seller')
                                <div
                                    class="badge position-absolute top-0 end-0 bg-primary fw-bold text-white px-2 text-wrap rounded-0 mt-2">
                                    <small>BEST SELLER</small>
                                </div>
                            @break

                            @case('produk_baru')
                                <div
                                    class="badge position-absolute top-0 end-0 bg-success fw-bold text-white px-2 text-wrap rounded-0 mt-2">
                                    <small>NEW</small>
                                </div>
                            @break

                            @default
                        @endswitch

                        <img class="card-img-top rounded-0" src="{{ $item->thumbnail_url }}" alt="{{ $item->thumbnail }}">
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
                        <div class="card-footer bg-white d-flex justify-content-center mb-2 border-0 pb-2"
                            id="card_footer{{ $key }}"onmouseover="card_hover({{ $key }})"
                            onmouseout="card_hout({{ $key }})">
                            <a href="{{ route('pages.cart.store', $item->id) }}"
                                class="btn btn-outline-warning btn-sm col-8 mx-1 rounded-0">
                                Add
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('js')
    <script>
        function card_hover(key) {
            $('#card' + key).removeClass('border-0 ');
            $('#card' + key).addClass('border-danger border-1 border-top border-start border-end border-bottom-0');
            $('#card_footer' + key).removeClass('border-0');
            $('#card_footer' + key).addClass('border-danger border-1 border-bottom border-start border-end border-top-0');
        }

        function card_hout(key) {
            $('#card' + key).removeClass('border-danger border-1 border-top border-start border-end border-bottom-0');
            $('#card' + key).addClass('border-0');
            $('#card_footer' + key).removeClass(
                'border-danger border-1 border-bottom border-start border-end border-top-0');
            $('#card_footer' + key).addClass('border-0');
        }
    </script>
@endsection
