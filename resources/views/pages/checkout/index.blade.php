@extends('pages.checkout.layout')
@section('title', 'Checkout')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/selectize-bootstrap4-theme@2.0.2/dist/css/selectize.bootstrap4.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="container bg-white text-center py-2 rounded-2 col-12 col-lg-8">
        <h3 class="fw-bold">Checkout Product</h3>
    </div>
    <div class="container mt-3 col-12 col-lg-8 mb-5">
        <form action="{{ route('pages.checkout.process') }}" method="POST">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-12 col-lg-8 px-2 my-2">
                    <div class="card border-0">
                        <div class="card-body">
                            <p class="fw-bold text-secondary"> <i class="fa fa-list-ul" aria-hidden="true"></i> List Product
                            </p>
                            @foreach ($product as $key => $item)
                                <input type="number" name="product_id[]" id="product_id{{ $key }}"
                                    value="{{ $item->id }}" class="d-none">
                                <div class="row">
                                    <div class="col-2 text-center m-auto">
                                        <div class="text-center">
                                            <img class="bg-secondary" src="{{ $item->thumbnail_url }}"
                                                alt="{{ $item->thumbnail }}" style="width: 50px">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <p class="fw-bold">{{ $item->name }}</p>
                                        <div class="col-5 mb-3">
                                            <div class="input-group text-center">
                                                <button class="btn btn-sm input-group-text btn-light btn_qty_minus"
                                                    id="btn_qty_minus{{ $key }}">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input type="number" name="qty[]" id="qty{{ $key }}"
                                                    class="form-control text-center bg-light-subtle border-0 fw-bold px-0 mx-0"
                                                    value="{{ $qty[$key] }}" min="1" readonly>
                                                <button class="btn btn-sm input-group-text btn-light btn_qty_plus"
                                                    id="btn_qty_plus{{ $key }}">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            {{-- @if (!$item->variant->isEmpty()) --}}
                                            {{-- @foreach ($item->variant as $keyvar => $variants)
                                                    <input type="radio" class="btn-check"
                                                        name="variant_id[{{ $key }}]"
                                                        id="variant{{ $key }}{{ $keyvar }}{{ $variants->id }}"
                                                        value="{{ $variants->id }}"
                                                        {{ $variants->id == $variant[$key] ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-secondary btn-sm me-2"
                                                        for="variant{{ $key }}{{ $keyvar }}{{ $variants->id }}">{{ $variants->name }}</label>
                                                @endforeach --}}
                                            {{-- @else --}}
                                            <input type="radio" class="btn-check" name="variant_id[{{ $key }}]"
                                                value="no_variant" checked>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    <div class="col-3 text-center fw-bold m-auto">
                                        <p id="price_list{{ $key }}">
                                        </p>
                                        {!! $item->arrival != 'promo'
                                            ? ''
                                            : ' <div class="badge bg-warning fw-medium text-white px-2 text-wrap rounded-0 mt-2"><small>PROMO</small></div>' !!}
                                        <input id="price{{ $key }}" type="number" class="d-none"
                                            value="{{ $item->discount_price ?? $item->price }}" required>
                                    </div>
                                </div>
                                <hr class="border-1 border-bottom border-secondary-subtle">
                            @endforeach

                            <div class="col-9">
                                <p class="fw-bold text-center">ALAMAT TUJUAN</p>
                            </div>
                            <div class="row d-flex justify-content-end mb-3">
                                <div class="col-9 fw-bold ">
                                    <select name="address" id="address" class="mb-1" required>
                                        <option value="">Pilih Alamat Tujuan</option>
                                    </select>
                                    <button id="searchAlamat" type="button" class="btn btn-primary btn-sm mb-2">Cari Alamat <i class="fa fa-search" aria-hidden="true"></i></button>
                                    <textarea name="address_full" id="address_full" class="form-control col-9" placeholder="Alamat Lengkap"></textarea>
                                </div>
                            </div>
                            <div class="col-9">
                                <p class="fw-bold text-center">JASA PENGIRIMAN</p>
                            </div>
                            <div class="row d-flex justify-content-end mb-3">
                                <div class="col-9 fw-bold ">
                                    <select name="kurir" id="kurir" class="mb-1 form-select " required>
                                        <option value=""> - Pilih Jasa Pengiriman -</option>
                                        <option value="jne">JNE</option>
                                        <option value="jnt">JNT</option>
                                        <option value="sicepat">SICEPAT</option>
                                    </select>
                                </div>
                                <div class="col-9 fw-bold ">
                                    <select name="service" id="service" class="mb-1 form-select ">
                                    </select>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-9">
                                    <p class="fw-bold text-center">BIAYA PENGIRIMAN</p>
                                </div>
                                <div class="col-3 text-center fw-bold m-auto">
                                    <p class="fw-bold" id="textOngkir"></p>
                                    <input type="number" id="ongkir" class="d-none" value="" required>
                                </div>
                            </div>
                            <hr class="border-1 border-bottom border-secondary-subtle">
                            <div class="row ">
                                <div class="col-9">
                                    <p class="fw-bold text-center">TOTAL HARGA</p>
                                </div>
                                <div class="col-3 text-center fw-bold m-auto">
                                    <p class="fw-bold" id="total_price"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-4 px-2 my-2">
                    <div class="card border-0">
                        <div class="card-body">
                            <p class="fw-bold text-secondary"> <i class="fa fa-credit-card" aria-hidden="true"></i> Pilih
                                Bank Pembayaran
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item bg-light border-0">
                                    <select class="form-select" name="payment_method" id="payment_method" required>
                                        <option value=""> - Pilih Bank Pembayaran - </option>
                                        <option value="TRANSFER BANK BCA">TRANSFER BANK BCA</option>
                                        <option value="TRANSFER BANK BRI">TRANSFER BANK BRI</option>
                                        <option value="TRANSFER BANK MANDIRI">TRANSFER BANK MANDIRI</option>
                                        <option value="TRANSFER BANK BNI">TRANSFER BANK BNI</option>
                                    </select>
                                </li>
                            </ul>
                            <hr class="border-1 border-bottom border-secondary-subtle">
                            <p class="fw-bold text-secondary "> <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                Delivery
                                Address
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-user-circle-o text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-envelope-o text-secondary"
                                            aria-hidden="true"></i></div>
                                    <div>{{ Auth::user()->email }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-whatsapp text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>{{ Auth::user()->phone }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-8 m-auto">
                <button type="submit" class="btn btn-primary col-12"> Pesan Sekarang</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            var total_price_val = 0; // Total harga awal
            var ongkir = parseInt($('#ongkir').val()) || 0; // Ambil ongkir saat pertama kali
        
            $(document).ready(function() {
                updateTotalPrice(); // Hitung total harga saat pertama kali halaman dimuat
        
                $('.btn_qty_plus, .btn_qty_minus').each(function(index, element) {
                    updatePrice(index);
                });
        
                // Event handler untuk tombol plus (+)
                $('.btn_qty_plus').each(function(index) {
                    $('#btn_qty_plus' + index).click(function(e) {
                        e.preventDefault();
                        var qty = parseInt($('#qty' + index).val()) || 0;
                        qty++;
                        $('#qty' + index).val(qty);
                        updatePrice(index);
                        updateTotalPrice();
                    });
                });
        
                // Event handler untuk tombol minus (-)
                $('.btn_qty_minus').each(function(index) {
                    $('#btn_qty_minus' + index).click(function(e) {
                        e.preventDefault();
                        var qty = parseInt($('#qty' + index).val()) || 0;
                        if (qty > 1) {
                            qty--;
                            $('#qty' + index).val(qty);
                            updatePrice(index);
                            updateTotalPrice();
                        }
                    });
                });
            });
        
            // Fungsi untuk menghitung total harga item per baris
            function updatePrice(index) {
                var qty = parseInt($('#qty' + index).val()) || 0;
                var price = parseInt($('#price' + index).val()) || 0;
                var total = qty * price;
                $('#price_list' + index).text(`Rp ${numberFormat(total, 0, 0, '.')}`);
            }
        
            // Fungsi untuk menghitung total harga semua item + ongkir
            function updateTotalPrice() {
                total_price_val = 0;
                $('.btn_qty_plus').each(function(index) {
                    var qty = parseInt($('#qty' + index).val()) || 0;
                    var price = parseInt($('#price' + index).val()) || 0;
                    total_price_val += qty * price;
                });
        
                ongkir = parseInt($('#ongkir').val()) || 0; // Ambil ongkir terbaru
                total_price_val += ongkir;
        
                $('#total_price').text(`Rp ${numberFormat(total_price_val, 0, 0, '.')}`);
            }
        
            // Event handler untuk perubahan ongkir
            $('#service').change(function(e) {
                e.preventDefault();
                $('#textOngkir').text(`Rp ${numberFormat(parseInt($(this).val()), 0, 0, '.')}`);
                $('#ongkir').val($(this).val());
                updateTotalPrice();
            });
        
            // Format angka ke format Rupiah
            function numberFormat(number, decimals, dec_point, thousands_sep) {
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
        
            // Selectize untuk pencarian alamat
            var select_address = $("#address").selectize();
            var selectize_address = select_address[0].selectize;
        
            let query = '';
        
            $('#searchAlamat').click(function (e) { 
                e.preventDefault();
                Swal.showLoading();
                
                selectize_address.clearOptions();
        
                $.ajax({
                    url: "{{ route('rongkir.search') }}",
                    type: 'GET',
                    data: { search: query },
                    dataType: 'JSON',
                    success: function(data) {
                        Swal.close();
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                selectize_address.addOption({
                                    text: item.label, 
                                    value: item.id
                                });
                            });
                            selectize_address.refreshOptions();
                        } else {
                            Swal.fire("Tidak ditemukan", "Alamat tidak tersedia.", "warning");
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire("Error", "Gagal mengambil data.", "error");
                    }
                });
            });
        
            selectize_address.on('type', function(str) {
                query = str;
            });
        
            $('#kurir').change(function (e) { 
                e.preventDefault();
                Swal.showLoading();
                let kurirs = $(this).val();
                let destinations = $('#address').val();
                if (!kurirs || !destinations) {
                    Swal.close();
                    Swal.fire("Peringatan", "Pilih kurir dan alamat tujuan terlebih dahulu!", "info");
                    $(this)[0].selectedIndex = 0;
                    return;
                }
                $.ajax({
                    url: "{{ route('rongkir.calculate') }}",
                    type: 'GET',
                    data: { 
                        kurir: kurirs,
                        destination_id: destinations,
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        Swal.close();
                        if (data.length > 0) {
                            $('#service').empty();
                            $('#service').append(`<option value="">- Pilih Layanan -</option>`);
                            $.each(data, function(index, item) {
                                $('#service').append(`<option value="${item.cost}">${item.service} - ${item.description} | Rp ${numberFormat(parseInt(item.cost), 0, 0, '.')}</option>`);
                            });
                        } else {
                            Swal.fire("Tidak ditemukan", "Layanan Tidak Ditemukan.", "warning");
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire("Error", "Gagal mengambil data.", "error");
                    }
                });
            });
        
        </script>
@endsection
