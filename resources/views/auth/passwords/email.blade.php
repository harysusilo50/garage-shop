@extends('auth.layout.app')
@section('title', 'Permintaan Reset Password')
@section('content')
    <div class="bg-dark vh-100">
        <div class="container ">
            <div class="row justify-content-center ">
                <div class="col-10 card rounded-0 mt-5 p-lg-5 p-3">
                    <div class="text-center col-lg-6 col-10 m-auto">
                        <img class="w-50 mb-3" src="{{ asset('img/forgot-password.svg') }}" alt="forgot-password">
                    </div>
                    <div class="container">
                        <h2 class="text-center mb-3">Reset Password</h2>
                        <p class="text-center ">
                            {{ __('Masukan alamat email yang terdaftar untuk melakukan reset password') }}
                        </p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="text-center " method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3 d-flex justify-content-center">
                                <div class="col-10 col-lg-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white rounded-0">
                                            <i class="fa fa-envelope  text-dark" aria-hidden="true"></i></span>
                                        <input id="email" type="email"
                                            class=" border-start-0 form-control rounded-0 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="btn_verif" class="btn btn-dark col-lg-4 col-10">
                                {{ __('Kirim link reset password') }}
                            </button>
                            <br>
                            atau
                            <br>
                            <a class="btn btn-secondary col-lg-4 col-10 mb-3" href="{{ route('home') }}">Kembali ke
                                Beranda</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
