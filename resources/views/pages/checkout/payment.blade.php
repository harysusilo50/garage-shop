@extends('pages.checkout.layout')
@section('title', 'Pembayaran Pesanan ' . $data->code)
@section('content')
    <div class="container bg-white text-center py-2 rounded-2 col-12 col-lg-8">
        <h3 class="fw-bold">Konfirmasi Pembayaran Pesanan</h3>
        <span class="text-success fw-bold">No. Invoice #{{ $data->code }}</span>
    </div>
    <div class="container mt-3 col-12 col-lg-8 mb-5">
        <form action="{{ route('payment.process', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="number" name="transaction_id" class="d-none" required value="{{ $data->id }}">
            <div class="row">
                <div class="col-12 col-lg-8 my-2">
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <p class="fw-bold">Total Pesanan</p>
                            <h2>Rp {{ $data->format_total_price }}</h2>
                            <hr class="border-1 border-bottom border-secondary-subtle">
                            <p class="fst-italic"><span class="text-danger">*</span>Proses pengecekan pembayaran dilakukan
                                maksimal1 x 24 jam hari kerja</p>
                        </div>
                    </div>
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <p class="fw-bold text-secondary"> <i class="fa fa-file-o" aria-hidden="true"></i>
                                Upload Bukti Pembayaran
                            </p>
                            <div class="col-auto">
                                <input type="file" class="form-control" name="payment_img" required>
                            </div>
                            <div class="col-auto">
                                <label for="bank_name" class="col-form-label fw-bold">Nama Bank
                                    <span class="text-danger">*</span></label>
                                <input name="bank_name" type="text" class="form-control" id="bank_name"
                                    placeholder="Nama Bank Pengirim" required>
                            </div>
                            <div class="col-auto">
                                <label for="no_rek" class="col-form-label fw-bold">No Rekening
                                    <span class="text-danger">*</span></label>
                                <input name="no_rek" type="text" class="form-control" id="no_rek"
                                    placeholder="Nomor Rekening Pengirim" required>
                            </div>
                            <div class="col-auto mb-3">
                                <label for="sender_name" class="col-form-label fw-bold">Atas Nama
                                    <span class="text-danger">*</span></label>
                                <input name="sender_name" type="text" class="form-control" id="sender_name"
                                    placeholder="Nama Pemilik Rekening" required>
                            </div>
                            <div class="col-auto text-center">
                                <button class="btn btn-primary" type="submit">Upload Bukti Pembayaran</button>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_id" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Produk [Variant]</th>
                                            <th>Jumlah</th>
                                            <th style="width: 20%">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->order as $item)
                                            <tr>
                                                <td class="text-center" style="width:5%">
                                                    {{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->product_name }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->qty }}
                                                </td>
                                                <td>
                                                    Rp {{ $item->format_price }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-center fw-bold">
                                                Jasa Pengiriman
                                            </td>
                                            <td class="fw-bold">Rp
                                                {{ $data->shipping->format_cost }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-center fw-bold">
                                                Total Harga
                                            </td>
                                            <td class="fw-bold">Rp
                                                {{ $data->format_total_price }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 my-2">
                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <p class="fw-bold text-secondary"> <i class="fa fa-credit-card" aria-hidden="true"></i>
                                Daftar Rekening
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item bg-light border-0">
                                    <div class="fw-bold">
                                        MANDIRI
                                    </div>
                                    <div>
                                        00076789097
                                    </div>
                                    <div>
                                        a.n BENGKEL CB RRM SPEED
                                    </div>
                                </li>
                                <hr class="border-1 border-bottom border-secondary-subtle">
                                <li class="list-group-item bg-primary-subtle border-0">
                                    <div class="fw-bold">
                                        BCA
                                    </div>
                                    <div>
                                        54708098023
                                    </div>
                                    <div>
                                        a.n BENGKEL CB RRM SPEED
                                    </div>
                                </li>
                                <hr class="border-1 border-bottom border-secondary-subtle">
                                <li class="list-group-item bg-warning-subtle border-0">
                                    <div class="fw-bold">
                                        BNI
                                    </div>
                                    <div>
                                        9008098023
                                    </div>
                                    <div>
                                        a.n BENGKEL CB RRM SPEED
                                    </div>
                                </li>
                                <hr class="border-1 border-bottom border-secondary-subtle">
                                <li class="list-group-item bg-danger-subtle border-0">
                                    <div class="fw-bold">
                                        BRI
                                    </div>
                                    <div>
                                        808098023
                                    </div>
                                    <div>
                                        a.n BENGKEL CB RRM SPEED
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <p class="fw-bold text-secondary"> <i class="fa fa-credit-card" aria-hidden="true"></i>
                                Payment
                                Method
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item bg-light border-0">
                                    {{ $data->payment_method }}
                                </li>
                            </ul>
                            <hr class="border-1 border-bottom border-secondary-subtle">
                            <p class="fw-bold text-secondary ">
                                <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                Detail Pengiriman
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-user-circle-o text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>{{ $data->user->name }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-envelope-o text-secondary"
                                            aria-hidden="true"></i></div>
                                    <div>{{ $data->user->email }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-whatsapp text-secondary"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>{{ $data->user->phone }}</div>
                                </li>
                                <li class="list-group-item border-0 pt-0 pb-1 px-1 d-flex bg-light border-0">
                                    <div class="col-1 text-center me-2"><i class="fa fa-map-marker text-secondary"
                                            aria-hidden="true"></i></div>
                                    <div>{{ $data->shipping->address }}</div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
