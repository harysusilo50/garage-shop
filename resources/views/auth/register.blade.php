@extends('auth.layout.app')
@section('title', 'Register')
@section('content')
    <div class="row  m-auto">
        <div class="col-12 col-lg-6 bg-white h-100 row m-auto">
            <div class="m-auto row col-10">
                <h1 class="fw-bold text-center mb-1 mt-3">Registrasi</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="col-md-4 col-form-label">{{ __('Nama Lengkap') }}</label>

                        <div class="col-12">
                            <input id="name" type="text" class="form-control rounded-0 @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>

                        <div class="col-12">
                            <input id="email" type="email" class="form-control rounded-0 @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-2">
                        <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                        <div class="col-12">
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control rounded-0 @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" onkeyup="cekPassword()">
                                <button type="button" class="input-group-text rounded-0" id="showHidePw">
                                    <i class="fa fa-eye" aria-hidden="true"></i></button>
                                <div class="invalid-feedback" role="alert" id="password_error">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label">{{ __('Konfirmasi Password') }}</label>
                        <div class="col-12">
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control rounded-0"
                                    name="password_confirmation" required autocomplete="new-password"
                                    onkeyup="cekPassword()">
                                <button type="button" class="input-group-text rounded-0" id="showHideConfPw">
                                    <i class="fa fa-eye" aria-hidden="true"></i></button>
                                <div class="invalid-feedback" role="alert" id="password_error_confirm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="phone" class="col-md-4 col-form-label">{{ __('No Telepon') }}</label>

                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text rounded-0">+62</span>
                                <input id="phone" type="text"
                                    class="form-control rounded-0 @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="phone">
                                <div class="invalid-feedback" role="alert" id="phone_error">
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="col-md-4 col-form-label">{{ __('Alamat') }}</label>

                        <div class="col-12">
                            <input id="address" type="text"
                                class="form-control rounded-0 @error('address') is-invalid @enderror" name="address"
                                value="{{ old('address') }}" required autocomplete="address">

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-dark col-12 rounded-0" id="register_btn">
                            {{ __('Register') }}
                        </button>
                        <p class="mt-2 mb-5">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>

                        <div class="text-center">
                            <a class="text-primary opacity-50 align-middle col-lg-6" href="{{ route('home') }}">
                                <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        $('#showHideConfPw').click(function(e) {
            e.preventDefault();
            var pw = $('#password-confirm').attr('type');
            if (pw === "password") {
                $('#password-confirm').attr('type', 'text');
            } else {
                $('#password-confirm').attr('type', 'password')
            }
        });

        // function validasiPassword(password) {
        //     let temp = ''
        //     // Cek panjang minimal
        //     if (password.length < 8) {
        //         temp += '<p class="mb-0"><strong>- Minimal 8 karakter</strong></p>';
        //     }
        //     // Cek keberadaan angka
        //     if (!/\d/.test(password)) {
        //         temp += '<p class="mb-0"><strong>- Harus memiliki angka</strong></p>';
        //     }
        //     // Cek keberadaan huruf kapital
        //     if (!/[A-Z]/.test(password)) {
        //         temp += '<p class="mb-0"><strong>- Harus memiliki huruf kapital</strong></p>';
        //     }
        //     // Cek keberadaan karakter khusus
        //     if (!/[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password)) {
        //         temp += '<p class="mb-0"><strong>- Harus terdapat karakter khusus</strong></p>';
        //     }

        //     return temp;
        // }

        // function cekPassword() {
        //     var password = $("#password").val();

        //     let validate = validasiPassword(password);
        //     if (!validate) {
        //         $('#password').removeClass('is-invalid');
        //         $('#password_error').empty();
        //         $('#register_btn').prop('disabled', false);
        //     } else {
        //         $('#password').addClass('is-invalid');
        //         $('#password_error').html(validate);
        //         $('#register_btn').prop('disabled', true);
        //         if (password.length === 0) {
        //             $('#password').removeClass('is-invalid');
        //             $('#password_error').empty();
        //             $('#register_btn').prop('disabled', false);
        //         }
        //     }
        //     var confirm = $("#password-confirm").val();

        //     if (password != confirm) {
        //         $('#password-confirm').addClass('is-invalid');
        //         $('#password_error_confirm').html(`<p class="mb-0"><strong>Password tidak sesuai</strong></p>`);
        //         $('#register_btn').prop('disabled', true);
        //         if (confirm.length === 0) {
        //             $('#password-confirm').removeClass('is-invalid');
        //             $('#password_error_confirm').empty();
        //             $('#register_btn').prop('disabled', false);
        //         }
        //     } else {
        //         $('#password-confirm').removeClass('is-invalid');
        //         $('#password_error_confirm').empty();
        //         $('#register_btn').prop('disabled', false);
        //     }
        // }
    </script>

    <script>
        //   function validateLengthPhone(phone) {
        //     let temp = ''
        //     // Cek panjang minimal
        //     if (phone.length < 10) {
        //         temp += '<p class="mb-0"><strong>No telepon minimal 12 digit</strong></p>';
        //     }

        //     return temp;
        // }

        // function checkLengthPhone() {
        //     let phone = $('#phone').val();

        //     let validate = validateLengthPhone(phone);
        //     if (!validate) {
        //         $('#phone').removeClass('is-invalid');
        //         $('#phone_error').empty();
        //         $('#register_btn').prop('disabled', false);
        //     } else {
        //         $('#phone').addClass('is-invalid');
        //         $('#phone_error').html(validate);
        //         $('#register_btn').prop('disabled', true);
        //         if (password.length === 0) {
        //             $('#phone').removeClass('is-invalid');
        //             $('#phone_error').empty();
        //             $('#register_btn').prop('disabled', false);
        //         }
        //     }
        // }

        // $('#phone').keypress(function(e) {
        //     let phone = $('#phone').val();
        //     checkLengthPhone();
        //     if (phone.charAt(0) === "0") {
        //         $('#phone').val(phone.substr(1));
        //     }
        //     var charCode = e.which;
        //     if (charCode < 48 || charCode > 57) {
        //         e.preventDefault();
        //     }
        // });
    </script>
@endsection
