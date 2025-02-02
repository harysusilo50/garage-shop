    <aside id="sidebar" class="sidebar bg-secondary">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link rounded-0 {{ Request::is('admin/dashboard') ? '' : 'collapsed text-black' }}"
                    href="{{ route('dashboard.admin') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link rounded-0 {{ Request::is('admin/banner') || Request::is('admin/banner/*') ? '' : 'collapsed text-black' }}"
                    href="{{ route('banner.index') }}">
                    <i class="bi bi-aspect-ratio"></i>
                    <span>Banner</span>
                </a>
            </li><!-- End Dashboard Nav -->
            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin_toko' || Auth::user()->role == 'admin_kepala')
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ Request::is('admin/user') ? '' : 'collapsed text-black' }} "
                        href="{{ route('admin.user.index') }}">
                        <i class="bi bi-person"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ Request::is('admin/brand') || Request::is('admin/brand/*') ? '' : 'collapsed text-black' }}"
                        data-bs-target="#brand-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-tags"></i><span>Brand</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="brand-nav"
                        class="nav-content bg-light {{ Request::is('admin/brand') || Request::is('admin/brand/*') ? '' : 'collapse bg-light' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="{{ Request::is('admin/brand') ? 'active' : '' }}"
                                href="{{ route('brand.index') }}">
                                <i class="bi bi-circle"></i><span>Kelola Brand</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ Request::is('admin/category') || Request::is('admin/category/*') ? '' : 'collapsed text-black' }}"
                        data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-diagram-2"></i><span>Category</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="category-nav"
                        class="nav-content bg-light {{ Request::is('admin/category') || Request::is('admin/category/*') ? '' : 'collapse bg-light' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="{{ Request::is('admin/category') ? 'active' : '' }}"
                                href="{{ route('category.index') }}">
                                <i class="bi bi-circle"></i><span>Kelola Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role == 'superadmin' ||
                    Auth::user()->role == 'admin_toko' ||
                    Auth::user()->role == 'admin_kepala' ||
                    Auth::user()->role == 'warehouse')
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ Request::is('admin/product') || Request::is('admin/stock') || Request::is('admin/product-stock-report') || Request::is('admin/product/*') ? '' : 'collapsed text-black' }}"
                        data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-box2"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="product-nav"
                        class="nav-content bg-light {{ Request::is('admin/product') || Request::is('admin/stock') || Request::is('admin/product-stock-report') || Request::is('admin/product/*') ? '' : 'collapse bg-light' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="{{ Request::is('admin/product') ? 'active' : '' }}"
                                href="{{ route('product.index') }}">
                                <i class="bi bi-circle"></i><span>Kelola Product</span>
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/stock') ? 'active' : '' }}"
                                href="{{ route('stock.index') }}">
                                <i class="bi bi-circle"></i><span>Kelola Stock Product</span>
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/product-stock-report') ? 'active' : '' }}"
                                href="{{ route('product.stock.report') }}">
                                <i class="bi bi-circle"></i><span>Laporan Stock Product</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ Request::is('admin/order') || Request::is('admin/order/*') ? '' : 'collapsed text-black' }}"
                        data-bs-target="#order-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-shop"></i><span>Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="order-nav"
                        class="nav-content bg-light {{ Request::is('admin/order') || Request::is('admin/order/*') ? '' : 'collapse bg-light' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="{{ Request::is('admin/order') && Request::query('status') == '' ? 'active' : '' }}"
                                href="{{ route('order.index') }}">
                                <i class="bi bi-circle"></i><span>Semua Pesanan</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role == 'bendahara' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin_kepala')
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ Request::is('admin/finance') || Request::is('admin/finance/*') ? '' : 'collapsed text-black' }}"
                        data-bs-target="#finance-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-cash-coin"></i><span>Financial</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="finance-nav"
                        class="nav-content bg-light {{ Request::is('admin/finance') || Request::is('admin/finance/*') ? '' : 'collapse bg-light' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="{{ Request::is('admin/finance') ? 'active' : '' }}"
                                href="{{ route('finance.index') }}">
                                <i class="bi bi-circle"></i><span>Financial Report</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link rounded-0 collapsed text-black" data-bs-target="#all-report" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-earmark-medical"></i><span>Report</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="all-report" class="nav-content collapse bg-white" data-bs-parent="#sidebar-nav">
                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin_toko' || Auth::user()->role == 'admin_kepala')
                        <li>
                            <a class="{{ Request::is('admin/user') ? 'active' : '' }}"
                                href="{{ route('admin.user.index') }}">
                                <i class="bi bi-circle"></i><span>User Report</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'bendahara' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin_kepala')
                        <li>
                            <a class="{{ Request::is('admin/finance') ? 'active' : '' }}"
                                href="{{ route('finance.index') }}">
                                <i class="bi bi-circle"></i><span>Financial Report</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'superadmin' ||
                            Auth::user()->role == 'admin_toko' ||
                            Auth::user()->role == 'admin_kepala' ||
                            Auth::user()->role == 'warehouse')
                        <li  class="nav-item">
                            <a class="{{ Request::is('admin/product-stock-report') ? 'active' : '' }}"
                                href="{{ route('product.stock.report') }}">
                                <i class="bi bi-circle"></i><span>Stock Product Report</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
    </aside>
