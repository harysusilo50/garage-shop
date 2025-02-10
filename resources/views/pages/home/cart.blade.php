@extends('pages.checkout.layout')
@section('title', 'Keranjang')
@section('content')
    <div class="container bg-white text-center py-2 rounded-2 col-12 col-lg-8">
        <h3 class="fw-bold">Keranjang</h3>
    </div>

    <div class="col-12 col-lg-8 my-2 mx-auto">
        <form id="checkout-form" action="{{ route('pages.checkout.index') }}" method="POST">
            @csrf
            <div class="card border-0">
                <div class="card-body">
                    <p class="fw-bold text-secondary"> <i class="fa fa-list-ul" aria-hidden="true"></i> List Produk
                    </p>
                    @foreach ($cart as $key => $item)
                        <div class="row align-items-center">
                            <!-- Checkbox -->
                            <div class="col-1 text-center">
                                <input type="checkbox" class="cart-checkbox" id="check{{ $key }}" data-index="{{ $key }}">
                            </div>

                            <div class="col-2 text-center">
                                <img class="bg-secondary" src="{{ $item->product->thumbnail_url }}"
                                    alt="{{ $item->product->thumbnail }}" style="width: 50px">
                            </div>

                            <div class="col-6">
                                <p class="fw-bold">{{ $item->product->name }}</p>
                                <input type="number" name="product_id" id="product_id{{ $key }}"
                                        class="d-none"
                                        value="{{ $item->product->id }}" readonly>
                                <div class="input-group text-center">
                                    <button class="btn btn-sm input-group-text btn-light btn_qty_minus"
                                        id="btn_qty_minus{{ $key }}" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" name="qty[]" id="qty{{ $key }}"
                                        class="form-control text-center bg-light-subtle border-0 fw-bold px-0 mx-0"
                                        value="{{ $item->qty }}" min="1" readonly>
                                    <button class="btn btn-sm input-group-text btn-light btn_qty_plus"
                                        id="btn_qty_plus{{ $key }}" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-3 text-center">
                                <p id="price_list{{ $key }}"></p>
                                @if ($item->product->arrival == 'promo')
                                    <div class="badge bg-warning text-white px-2"><small>PROMO</small></div>
                                @endif
                                <input id="price{{ $key }}" type="hidden"
                                    value="{{ $item->product->discount_price ?? $item->product->price }}">

                                <button class="btn btn-danger btn-sm mt-3 rounded-0"
                                    onclick="delete_cart('{{ $item->id }}')" type="button">
                                    Remove <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <hr class="border-1 border-secondary-subtle">
                    @endforeach
                    <div class="row">
                        <div class="col-9">
                            <p class="fw-bold text-center">TOTAL PRICE</p>
                        </div>
                        <div class="col-3 text-center fw-bold">
                            <p class="fw-bold" id="total_price"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center justify-content-lg-end mt-3">
                <button class="btn btn-primary btn-lg rounded-0 col-8 col-lg-4" type="submit">
                    Checkout
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        let total_price_val = 0;

        // Update harga di awal
        $('.btn_qty_plus').each(function(index) {
            updatePrice(index);
        });

        // Menambah jumlah produk
        $('.btn_qty_plus').click(function(e) {
            e.preventDefault();
            let index = $(this).attr('id').replace('btn_qty_plus', '');
            let qty = parseInt($('#qty' + index).val()) + 1;
            $('#qty' + index).val(qty);
            updatePrice(index);
        });

        // Mengurangi jumlah produk
        $('.btn_qty_minus').click(function(e) {
            e.preventDefault();
            let index = $(this).attr('id').replace('btn_qty_minus', '');
            let qty = parseInt($('#qty' + index).val()) - 1;
            qty = qty < 1 ? 1 : qty;
            $('#qty' + index).val(qty);
            updatePrice(index);
        });

        // Mengupdate total harga
        function updatePrice(index) {
            let qty = parseInt($('#qty' + index).val());
            let price = parseInt($('#price' + index).val());
            let total = qty * price;
            $('#price_list' + index).text(`Rp ${numberFormat(total, 0, 0, '.')}`);
            updateTotalPrice();
        }

        // Mengupdate total harga keseluruhan
        function updateTotalPrice() {
            total_price_val = 0;
            $('.cart-checkbox:checked').each(function() {
                let index = $(this).data('index');
                let qty = parseInt($('#qty' + index).val());
                let price = parseInt($('#price' + index).val());
                total_price_val += qty * price;
            });
            $('#total_price').text(`Rp ${numberFormat(total_price_val, 0, 0, '.')}`);
        }

        // Update total harga saat checkbox dicentang
        $('.cart-checkbox').change(function() {
            updateTotalPrice();
        });

        // Format angka ke rupiah
        function numberFormat(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            let n = !isFinite(+number) ? 0 : +number;
            let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
            let sep = thousands_sep || ',';
            let dec = dec_point || '.';
            let s = '';
            let toFixedFix = function(n, prec) {
                let k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Kirim hanya item yang dicentang
        $('#checkout-form').submit(function(e) {
            e.preventDefault();
            let selectedItems = $('.cart-checkbox:checked');

            if (selectedItems.length === 0) {
                alert('Pilih minimal satu produk untuk checkout.');
                return;
            }

            selectedItems.each(function() {
                let index = $(this).data('index');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'product_id[]',
                    value: $('#product_id' + index).val()
                }).appendTo('#checkout-form');
            });

            this.submit();
        });

        function delete_cart(id) {
            let url = "{{ url('/') }}" + "/cart/delete/" + id;
            $.post(url, {
                _token: "{{ csrf_token() }}"
            }, function(data) {}, "JSON");
            location.reload();
        }
    });
</script>
@endsection
