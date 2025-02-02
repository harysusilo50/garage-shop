@extends('auth.layout.app')
@section('title', 'Login')
@section('content')
    <div class="row vh-100 m-auto">
        <div class="col-12 col-lg-6 m-auto bg-white h-100 row">
            <div class="m-auto row col-10">
                <h1 class="fw-bold mb-4 text-center">Login</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>
                        <div class="col-12">
                            <input id="email" type="email" class="form-control rounded-0 @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>


                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                        <div class="col-12">
                            <input id="password" type="password"
                                class="form-control rounded-0 @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">


                        </div>
                    </div>
                    <div class="mb-3">

                        <button type="submit" class="btn btn-dark rounded-0 col-12">
                            {{ __('Login') }}
                        </button>


                        @if (Route::has('password.request'))
                            <p class="my-2">Lupa Password?
                                <a href="{{ route('password.request') }}">
                                    {{ __('Klik disini') }}
                                </a>
                            </p>
                        @endif
                        <p class="mb-2">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
                    </div>
                    <div class="text-center">
                        <a class="text-primary opacity-50 align-middle col-lg-6" href="{{ route('home') }}">
                            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- @section('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection --}}
