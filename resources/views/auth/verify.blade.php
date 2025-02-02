@extends('auth.layout.app')
@section('title', 'Verifikasi Akun ' . auth()->user()->name)

@section('content')
    <div class="bg-dark vh-100">
        <div class="container ">
            <div class="row justify-content-center ">
                <div class="col-10 card rounded-0 mt-5 p-lg-5 p-3">
                    <div class="text-center col-lg-6 col-10 m-auto">
                        <img class="w-50 mb-3" src="{{ asset('img/verify-email.svg') }}" alt="verify-email">
                    </div>
                    <div class="container">
                        <h2 class="text-center mb-3">Verifikasi Alamat Email Anda!</h2>
                        <p class="text-center ">
                            {{ __('Sebelum melanjutkan, silakan cek link verifikasi yang telah dikirimkan ke alamat email anda. Jika anda tidak menerima apapun, klik tombol dibawah untuk melakukan pengiriman ulang link verifikasi') }}
                        </p>
                        <form class="text-center " method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" id="btn_verif" class="btn btn-dark rounded-0 col-lg-4 col-10" disabled>
                                {{ __('Kirim ulang link verifikasi') }}
                            </button>
                            <br>
                            atau
                            <br>
                            <a class="btn btn-secondary rounded-0 col-lg-4 col-10" href="{{ route('home') }}">Kembali ke Beranda</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            let time = 15;
            var interval;
            interval = setInterval(() => {
                time--;
                $('#btn_verif').html('Mohon tunggu.... ' + time + ' detik');

                if (time == 0) {
                    clearInterval(interval);
                    $('#btn_verif').removeAttr('disabled');
                    $('#btn_verif').text('Kirim ulang link verifikasi');
                    return false
                }
            }, 1000);

        });
    </script>
@endsection
