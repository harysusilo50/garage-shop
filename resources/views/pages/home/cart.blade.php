@extends('pages.checkout.layout')
@section('title', 'Keranjang')
@section('content')
    <div class="container bg-white text-center py-2 rounded-2 col-12 col-lg-8">
        <h3 class="fw-bold">Keranjang</h3>
    </div>

    <div class="col-12 col-lg-8  my-2 mx-auto">
        <form action="{{ route('pages.checkout.index') }}" method="POST">
            @csrf
            <div class="card border-0">
                <div class="card-body">
                    <p class="fw-bold text-secondary"> <i class="fa fa-list-ul" aria-hidden="true"></i> List Produk
                    </p>
                    @foreach ($cart as $key => $item)
                        <input type="number" name="product_id[]" id="product_id{{ $key }}"
                            value="{{ $item->product->id }}" class="d-none">
                        <div class="row">
                            <div class="col-2 text-center m-auto">
                                <div class="text-center">
                                    <img class="bg-secondary" src="{{ $item->product->thumbnail_url }}"
                                        alt="{{ $item->product->thumbnail }}" style="width: 50px">
                                </div>
                            </div>
                            <div class="col-7">
                                <p class="fw-bold">{{ $item->product->name }}</p>
                                <div class="col-5 mb-3 ">
                                    <div class="input-group text-center">
                                        <button class="btn btn-sm input-group-text btn-light btn_qty_minus"
                                            id="btn_qty_minus{{ $key }}">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                        <input type="number" name="qty[]" id="qty{{ $key }}"
                                            class="form-control text-center bg-light-subtle border-0 fw-bold px-0 mx-0"
                                            value="1" min="1" readonly>
                                        <button class="btn btn-sm input-group-text btn-light btn_qty_plus"
                                            id="btn_qty_plus{{ $key }}">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    {{-- @if (!$item->product->variant->isEmpty()) --}}
                                    {{-- @foreach ($item->product->variant as $keyvar => $variants)
                                            <input type="radio" class="btn-check" name="variant_id[{{ $key }}]"
                                                id="variant{{ $key }}{{ $keyvar }}{{ $variants->id }}"
                                                value="{{ $variants->id }}" {{ $keyvar == 0 ? 'checked' : '' }}>
                                            <label class="btn btn-outline-secondary btn-sm me-2"
                                                for="variant{{ $key }}{{ $keyvar }}{{ $variants->id }}">{{ $variants->name }}</label>
                                        @endforeach --}}
                                    {{-- @else --}}
                                    <input type="radio" class="btn-check" name="variant_id[{{ $key }}]"
                                        value="no_variant" id="variant{{ $key }}" checked>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="col-3 text-center fw-bold m-auto">
                                <p id="price_list{{ $key }}">
                                </p>
                                {!! $item->product->arrival != 'promo'
                                    ? ''
                                    : ' <div class="badge bg-warning fw-medium text-white px-2 text-wrap rounded-0 mt-2"><small>PROMO</small></div>' !!}
                                <input id="price{{ $key }}" type="number" class="d-none"
                                    value="{{ $item->product->discount_price ?? $item->product->price }}" required>
                                <button class="btn btn-danger btn-sm mt-3 rounded-0"
                                    onclick="delete_cart('{{ $item->id }}')" type="button">Remove
                                    <i class="fa fa-trash" aria-hidden="true"></i></button>

                            </div>
                        </div>
                        <hr class="border-1 border-bottom border-secondary-subtle">
                    @endforeach
                    <div class="row">
                        <div class="col-9">
                            <p class="fw-bold text-center">TOTAL PRICE</p>
                        </div>
                        <div class="col-3 text-center fw-bold m-auto">
                            <p class="fw-bold" id="total_price"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center justify-content-lg-end mt-3 ">
                <button class="btn btn-primary btn-lg rounded-0 col-8 col-lg-4" type="submit">
                    Checkout
                </button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        var total_price_val = 0;
        $(document).ready(function() {
            $('.btn_qty_plus').each(function(index, element) {
                var qty = $('#qty' + index).val();
                var price = $('#price' + index).val();
                var temp = qty * parseInt(price);
                var total = `Rp ${numberFormat(temp,0,0,'.')}`;
                $('#price_list' + index).text(total);
                total_price_val += parseInt(temp);
                $('#total_price').text(`Rp ${numberFormat(parseInt(total_price_val),0,0,'.')}`);
            });
        });

        $('.btn_qty_plus').each(function(index, element) {
            console.log(total_price_val)
            $('#btn_qty_minus' + index).click(function(e) {
                e.preventDefault();
                var qty = $('#qty' + index).val();
                var price = $('#price' + index).val();
                if (qty > 1) {
                    total_price_val -= parseInt(price);
                    $('#total_price').text(`Rp ${numberFormat(parseInt(total_price_val),0,0,'.')}`);
                }
                qty--;
                qty = qty < 1 ? 1 : qty;
                $('#qty' + index).val(qty);
                var total = `Rp ${numberFormat(qty * parseInt(price),0,0,'.')}`;
                $('#price_list' + index).text(total);
            });
            $('#btn_qty_plus' + index).click(function(e) {
                e.preventDefault();
                var qty = $('#qty' + index).val();
                qty++;
                $('#qty' + index).val(qty);
                var price = $('#price' + index).val();
                var total = `Rp ${numberFormat(qty * parseInt(price),0,0,'.')}`;
                $('#price_list' + index).text(total);
                total_price_val += parseInt(price);
                $('#total_price').text(`Rp ${numberFormat(parseInt(total_price_val),0,0,'.')}`);
            });

        });
        // number format
        const numberFormat = (number, decimals, dec_point, thousands_sep) => {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        };

        function delete_cart(id) {
            var url = "{{ url('/') }}" + "/cart/delete/" + id;
            $.post(url, {
                    _token: "{{ csrf_token() }}"
                },
                function(data, textStatus, jqXHR) {},
                "JSON"
            );
            location.reload();
        }
    </script>
@endsection
