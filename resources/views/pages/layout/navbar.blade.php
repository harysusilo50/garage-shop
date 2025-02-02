    <nav class="bg-dark">
        <div class="container col-12 d-flex justify-content-center py-2">
            <div class="col-2 m-auto text-center d-none d-lg-block">
                <a href=""><img class="w-50" src="{{ asset('img/logo.png') }}" alt=""
                        srcset="" /></a>
            </div>
            <div class="col-12 col-lg-10">
                <div class="container d-flex justify-content-lg-start mb-2 justify-content-center">
                    <div class="my-auto">
                       <h2 class="text-white mb-0">BENGKEL CB RRM SPEED</h2>
                    </div>
                </div>
                <div class="container">
                    <div class="col-12 d-flex justify-content-between mb-3 mb-lg-0">
                        <div class="col-12 col-lg-8 d-flex justify-content-between text-center mb-2">
                            <form class="input-group" action="{{ route('pages.search') }}" method="GET"
                                id="search_form">
                                <span class="input-group-text border-0 bg-white rounded-0"><i class="fa fa-search"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control border-0 shadow-none" id="search_bar"
                                    placeholder="Cari yang anda butuhkan disini" name="search" value="{{ $search ?? '' }}" />
                                <span class="input-group-text border-0 bg-white pe-0 me-0 rounded-0" id="clear_search"
                                    style="display: none">
                                    <button class="btn btn-close btn-sm" type="reset"></button>
                                </span>
                            </form>
                            <a href="{{ route('pages.cart.index') }}"
                                class="text-light position-relative ms-3">
                                <i class="fa fa-2x fa-cart-plus" aria-hidden="true"></i>
                                {!! $cart
                                    ? '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-dark">' .
                                        $cart .
                                        '<span class="visually-hidden">cart</span></span>'
                                    : '' !!}
                            </a>
                        </div>
                        <div
                            class="d-none d-lg-block col-lg-3 text-end text-white d-flex justify-content-between align-items-center">
                            @if (Auth::guest())
                                <a href="{{ route('login') }}" class="btn btn-outline-light rounded-0 fw-medium">Masuk <i class="fa fa-sign-in" aria-hidden="true"></i></a>
                            @else
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-outline-light rounded-0 {{ $title == 'Profile' ? 'active' : '' }}"
                                        onclick="location.href='{{ route('pages.profile.index', Auth::user()->hash_id) }}'">Profile
                                        <i class="fa fa-user-circle" aria-hidden="true"></i></button>
                                    <button type="button"
                                        class="btn btn-light rounded-0 dropdown-toggle dropdown-toggle-split text-dark"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu rounded-0">
                                        <li>
                                            <div class="dropdown-item">
                                                <p class="m-0">{{ Auth::user()->name }}</p>
                                                <p class="mb-2 small">{{ Auth::user()->email }}</p>
                                            </div>
                                        </li>
                                        @if (Auth::user()->role == 'superadmin' ||
                                                Auth::user()->role == 'bendahara' ||
                                                Auth::user()->role == 'warehouse' ||
                                                Auth::user()->role == 'admin_toko' ||
                                                Auth::user()->role == 'admin_kepala')
                                            <li><a class="dropdown-item" href="{{ route('dashboard.admin') }}">
                                                    Halaman Admin
                                                </a>
                                            </li>
                                        @endif
                                        <li><a class="dropdown-item"
                                                href="{{ route('pages.profile.index', Auth::user()->hash_id) }}">Riwayat
                                                Transaksi</a></li>
                                        <li><a class="dropdown-item" href="{{ route('password.request') }}">Ubah
                                                Password</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-center">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button class="btn btn-dark col-12 rounded-0" type="submit">
                                                        <i class="fa fa-power-off"></i> Keluar
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="navbar navbar-expand-lg navbar-dark p-lg-0">
                        <div class="container justify-content-between">
                            <h4 class="text-white fw-medium d-lg-none">Menu</h4>
                            <button class="navbar-toggler mb-2" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#navbar_category" aria-controls="navbar_category" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="offcanvas offcanvas-start " id="navbar_category">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title col-8" id="offcanvasExampleLabel">
                                        <img src="{{ asset('img/logo.png') }}" class="w-25" alt="logo">
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body bg-dark">
                                    <div class="navbar-nav">

                                        <div class="container d-lg-none col-12 text-white text-center mt-4 mb-3">
                                            @if (Auth::guest())
                                                <a href="{{ route('login') }}"
                                                    class="btn btn-outline-light col-10 fw-medium">Login</a>
                                                <div class="col-10 text-center mx-auto">or</div>
                                                <a href=" {{ route('register') }}"
                                                    class="btn btn-light col-10 fw-medium">Sign
                                                    up</a>
                                            @else
                                                <div class="dropdown-item">
                                                    <i class="fa fa-user-circle fs-1" aria-hidden="true"></i>
                                                    <p class="m-0">{{ Auth::user()->name }}</p>
                                                    <p class="mb-2 small">{{ Auth::user()->email }}</p>
                                                    <a href="{{ route('pages.profile.index', Auth::user()->hash_id) }}"
                                                        class="btn btn-sm btn-outline-light {{ $title == 'Profile' ? 'active' : '' }}">Go
                                                        To
                                                        Profile</a>
                                                </div>
                                            @endif
                                        </div>
                                        @if (!Auth::guest())
                                            @if (Auth::user()->role != 'user')
                                                <a class="nav-link btn btn-dark fw-bold text-start px-3 rounded-0 d-lg-none"
                                                    aria-current="page" href="{{ route('dashboard.admin') }}">Halaman
                                                    Admin</a>
                                            @endif
                                            <a class="nav-link btn btn-dark fw-bold text-start px-3 rounded-0 d-lg-none"
                                                aria-current="page"
                                                href="{{ route('pages.profile.index', Auth::user()->hash_id) }}">Riwayat
                                                Transaksi</a>
                                            <a class="nav-link btn btn-dark fw-bold text-start px-3 rounded-0 d-lg-none"
                                                aria-current="page" href="{{ route('password.request') }}">Ubah
                                                Password</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="offcanvas-bottom d-lg-none">
                                    <div class="text-center">
                                        @if (!Auth::guest())
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="btn btn-dark col-8 rounded-0" type="submit">
                                                    <i class="fa fa-power-off"></i> Keluar
                                                </button>
                                            </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="order_tracking_modal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId"><i class="fa fa-search-plus" aria-hidden="true"></i>
                        Order Tracking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pages.tracking') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search Order" name="code"
                                aria-label="Search Order" value="{{ $search ?? '' }}"
                                aria-describedby="search_button" />
                            <button class="btn btn-success" type="submit" id="search_button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <small class="ms-2 mt-0 fst-italic">Masukan Kode Transaksi Pesanan</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
