
<div class="collapse d-md-flex col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark sidebar" id="sidebar">
    <!-- Mobile Close Button -->
    <div class="d-flex justify-content-end p-2 d-md-none">
        <button class="btn btn-sm btn-danger" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="d-flex flex-column align-items-start px-3 pt-3 text-white min-vh-100 w-100">
        <!-- Brand Logo -->
        <a href="{{ route('customer.dashboard') }}" class="text-white text-decoration-none w-100 mb-4">
            <span class="fs-5 d-flex align-items-center">
                <span class="d-none d-md-inline"><i class="fas fa-motorcycle me-2"></i></span>
                MyBikeStore
            </span>
        </a>

        <!-- Sidebar Menu -->
        <ul class="nav nav-pills flex-column mb-auto w-100" id="menu">
            <li class="nav-item">
                <a href="{{ route('customer.dashboard') }}"
                   class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt d-none d-md-inline"></i>
                    <span class="d-inline">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.bike-builder') }}"
                   class="nav-link {{ request()->routeIs('customer.bike-builder') ? 'active' : '' }}">
                    <i class="fas fa-tools d-none d-md-inline"></i>
                    <span class="d-inline">Build Your Bike</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders') }}"
                   class="nav-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list d-none d-md-inline"></i>
                    <span class="d-inline">My Orders</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('customer.orders.history') }}"
                   class="nav-link {{ request()->routeIs('customer.orders.history') ? 'active' : '' }}">
                    <i class="fas fa-history d-none d-md-inline"></i>
                    <span class="d-inline">Order History</span>
                </a>
            </li>
        </ul>

        @include('partials.user-profile-dropdown')
    </div>
</div>
