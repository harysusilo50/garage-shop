 <header id="header" class="header fixed-top d-flex align-items-center bg-dark text-light">

     <div class="d-flex align-items-center justify-content-between">
         <a href="{{ route('home') }}" class="logo d-flex align-items-center fw-bold text-light">
             <img src="{{ asset('img/logo.png') }}" alt="">
             BENGKEL CB RRM SPEED
         </a>
         <button class="btn btn-outline-light toggle-sidebar-btn me-2" type="button">
             <i class="bi bi-list fs-5"></i></button>
     </div><!-- End Logo -->

     <nav class="header-nav ms-auto">
         <ul class="d-flex align-items-center">

             <li class="nav-item dropdown pe-3">

                 <a class="nav-link nav-profile d-flex align-items-center pe-3 text-light" href="#"
                     data-bs-toggle="dropdown">
                     <span class="dropdown-toggle ps-2">
                         <i class="bi bi-person-circle text-light"></i>
                     </span>
                 </a><!-- End Profile Iamge Icon -->

                 <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile text-light rounded-0">
                     <li class="dropdown-header">
                         <h6>{{ Auth::user()->name }}</h6>
                         <span>{{ Auth::user()->role }}</span>
                     </li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>

                     <li>
                         {{-- <a class="dropdown-item d-flex align-items-center"
                             href="{{ route('show.profile', Auth::user()->id) }}">
                             <i class="bi bi-person"></i>
                             <span>My Profile</span>
                         </a> --}}
                     </li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li>
                         <form method="POST" action="{{ route('logout') }}">
                             @csrf
                             <button class="dropdown-item btn btn-danger col-12 rounded-0" type="submit">
                                 <i class="fa fa-power-off"></i> Keluar
                             </button>
                         </form>
                     </li>

                 </ul><!-- End Profile Dropdown Items -->
             </li><!-- End Profile Nav -->

         </ul>
     </nav><!-- End Icons Navigation -->

 </header>
