<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('Icons/icon.png') }}" alt="navbar brand" class="navbar-brand" height="50" />
                <span class="text-white"> Cửa hàng MMO</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Thống kê</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders') }}" class="collapsed">
                        <i class="fas fa-shopping-bag"></i>
                        <p>Quản lí đơn hàng</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs(['admin.products', 'admin.products.add', 'admin.products.edit']) ? 'active' : '' }}">
                    <a href="{{ route('admin.products') }}" class="collapsed">
                        <i class="fas fa-shopping-bag"></i>
                        <p>Quản lí gian hàng</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
