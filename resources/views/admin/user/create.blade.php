@extends('admin.layout.app')
@section('title', 'Tambah User')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body p-3">
                            <h5 class="card-title">Create New <span>| User</span></h5>
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
                            <form method="POST" action="{{ route('admin.user.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-lg-3 col-form-label fw-bold">Nama
                                        Lengkap</label>
                                    <div class="col-md-8 col-lg-6">
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="John Doe" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-lg-3 col-form-label fw-bold">Email</label>
                                    <div class="col-md-8 col-lg-6">
                                        <input name="email" type="email" class="form-control" id="email"
                                            placeholder="email@example.com" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-lg-3 col-form-label fw-bold">Password</label>
                                    <div class="col-md-8 col-lg-6 ">
                                        <div class="input-group">
                                            <input name="password" type="password" class="form-control" id="password"
                                                placeholder="input password" onkeyup="cekPassword()" required>
                                            <button class="input-group-text bg-light" id="showHidePw" type="button">
                                                <i class="bi bi-eye-fill"></i></button>
                                            <div class="invalid-feedback" role="alert" id="password_error">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-lg-3 col-form-label fw-bold">Phone</label>
                                    <div class="col-md-8 col-lg-6">
                                        <div class="input-group ">
                                            <span class="input-group-text bg-light">
                                                +62</span>
                                            <input name="phone" type="numeric" class="form-control" id="phone"
                                                placeholder="81234567890" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address"
                                        class="col-md-4 col-lg-3 col-form-label fw-bold">Address</label>
                                    <div class="col-md-8 col-lg-6">
                                        <input name="address" type="text" class="form-control" id="address" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="role" class="col-md-4 col-lg-3 col-form-label fw-bold">Role</label>
                                    <div class="col-md-8 col-lg-6">
                                        <select class="form-control" name="role" id="role">
                                            <option value="" selected disabled>-Pilih Role-</option>
                                            <option value="bendahara">Bendahara</option>
                                            <option value="warehouse">Warehouse</option>
                                            <option value="admin_toko">Admin Toko</option>
                                            <option value="admin_kepala">Admin Kepala</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submit"
                                        class="btn btn-primary col-8 col-md-4 m-2">Save</button>
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-danger col-8 col-md-4 m-2">
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
        $('#showHidePw').click(function(e) {
            e.preventDefault();
            var pw = $('#password').attr('type');
            if (pw === "password") {
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password')
            }
        });

        function validasiPassword(password) {
            let temp = ''
            // Cek panjang minimal
            if (password.length < 8) {
                temp += '<p class="mb-0"><strong>- Minimal 8 karakter</strong></p>';
            }
            // Cek keberadaan angka
            if (!/\d/.test(password)) {
                temp += '<p class="mb-0"><strong>- Harus memiliki angka</strong></p>';
            }
            // Cek keberadaan huruf kapital
            if (!/[A-Z]/.test(password)) {
                temp += '<p class="mb-0"><strong>- Harus memiliki huruf kapital</strong></p>';
            }
            // Cek keberadaan karakter khusus
            if (!/[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password)) {
                temp += '<p class="mb-0"><strong>- Harus terdapat karakter khusus</strong></p>';
            }

            return temp;
        }

        function cekPassword() {
            var password = $("#password").val();

            let validate = validasiPassword(password);
            if (!validate) {
                $('#password').removeClass('is-invalid');
                $('#password_error').empty();
                $('#submit').prop('disabled', false);
            } else {
                $('#password').addClass('is-invalid');
                $('#password_error').html(validate);
                $('#submit').prop('disabled', true);
                if (password.length === 0) {
                    $('#password').removeClass('is-invalid');
                    $('#password_error').empty();
                    $('#submit').prop('disabled', false);
                }
            }
        }


        $('#phone').keypress(function(e) {
            let phone = $('#phone').val();
            if (phone.charAt(0) === "0") {
                $('#phone').val(phone.substr(1));
            }
            var charCode = e.which;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });
    </script>
@endsection
