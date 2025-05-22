<div class="collapse d-md-flex col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" id="sidebar">
    <!-- Mobile Close Button -->
    <div class="d-flex justify-content-end p-2 d-md-none">
        <button class="btn btn-sm btn-danger" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <!-- Brand Logo -->
        <a href="{{ route('customer.dashboard') }}"
            class="d-flex align-items-center pb-3 mb-md-0 mt-3 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">
                <i class="fas fa-motorcycle me-2"></i> MyBikeStore
            </span>
            <span class="fs-5 d-inline d-sm-none">
                <i class="fas fa-motorcycle"></i>
            </span>
        </a>

        <!-- Sidebar Menu -->
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100"
            id="menu">
            <!-- Dashboard -->
            <li class="nav-item w-100">
                <a href="{{ route('customer.dashboard') }}"
                   class="nav-link align-middle px-0 text-white {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <i class="fs-4 fas fa-tachometer-alt"></i>
                    <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
            </li>

            <!-- Bike Builder -->
            <li class="nav-item w-100">
                <a href="{{ route('customer.bike-builder') }}"
                   class="nav-link px-0 align-middle text-white {{ request()->routeIs('customer.bike-builder') ? 'active' : '' }}">
                    <i class="fs-4 fas fa-tools"></i>
                    <span class="ms-1 d-none d-sm-inline">Build Your Bike</span>
                </a>
            </li>

            <!-- Current Orders -->
            <li class="nav-item w-100">
                <a href="{{ route('customer.orders') }}"
                   class="nav-link px-0 align-middle text-white {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                    <i class="fs-4 fas fa-clipboard-list"></i>
                    <span class="ms-1 d-none d-sm-inline">My Orders</span>
                </a>
            </li>

            <!-- Order History -->
            <li class="nav-item w-100">
                <a href="{{ route('customer.orders.history') }}"
                   class="nav-link px-0 align-middle text-white {{ request()->routeIs('customer.orders.history') ? 'active' : '' }}">
                    <i class="fs-4 fas fa-history"></i>
                    <span class="ms-1 d-none d-sm-inline">Order History</span>
                </a>
            </li>
        </ul>

        @include('partials.user-profile-dropdown')
    </div>
</div>
