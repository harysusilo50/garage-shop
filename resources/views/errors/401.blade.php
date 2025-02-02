@extends('auth.layout.app')
@section('title', 'Error: 401')
@section('content')
    <div class="bg-danger vh-100">
        <div class="container ">
            <div class="row justify-content-center ">
                <div class="col-10 card rounded-4 mt-5 p-lg-5 p-3">
                    <div class="text-center col-lg-6 col-10 m-auto">
                        <img class="w-50 mb-3" src="{{ asset('img/401.svg') }}" alt="reset-password">
                    </div>
                    <div class="container">
                        <h1 class="text-center mb-1">401</h1>
                        <h3 class="text-center mb-5">
                            {{ __('Unauthorized') }}
                        </h3>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary" href="{{ route('login') }}"> <i class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i> Kembali</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
