@extends('auth.layout.app')
@section('title', 'Reset Password')
@section('content')
    <div class="bg-dark vh-100">
        <div class="container ">
            <div class="row justify-content-center ">
                <div class="col-10 card rounded-4 mt-5 p-lg-5 p-3">
                    <div class="text-center col-lg-6 col-10 m-auto">
                        <img class="w-50 mb-3" src="{{ asset('img/reset-password.svg') }}" alt="reset-password">
                    </div>
                    <div class="container">
                        <h2 class="text-center mb-3">Reset Password</h2>
                        <p class="text-center ">
                            {{ __('Masukan password baru anda') }}
                        </p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control rounded-0 @error('email') is-invalid @enderror bg-light" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                        readonly>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control rounded-0 @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control rounded-0"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" id="btn_verif" class="btn btn-dark col-lg-4 col-10 rounded-0">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
