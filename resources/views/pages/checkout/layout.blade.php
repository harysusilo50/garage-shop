<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> @yield('title') | BENGKEL CB RRM SPEED Online Shop</title>
    <link rel="stylesheet" href="{{ asset('pages/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    @include('pages.layout.css')
</head>

<body style="font-family: Roboto, sans-serif" class="bg-light">
    @include('sweetalert::alert')

    <nav class="navbar navbar-dark bg-dark position-relative d-flex justify-content-center mb-3">
        <a class="btn btn-dark position-absolute top-50 start-0 ms-2 translate-middle-y" href="{{ route('home') }}">
            <i class="fa fa-chevron-left fs-6" aria-hidden="true"></i>
            Kembali</a>
        <div class="text-center  navbar-nav">
            <img src="{{ asset('img/logo.png') }}" alt="logo" style="height: 50px">
        </div>
    </nav>
    @yield('content')

    @include('pages.layout.js')
</body>

</html>
