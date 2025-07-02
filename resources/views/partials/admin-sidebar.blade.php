<div class="collapse d-md-flex col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark sidebar" id="sidebar">
    <!-- Mobile Close Button -->
    <div class="d-flex justify-content-end p-2 d-md-none">
        <button class="btn btn-sm btn-danger" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="d-flex flex-column align-items-start px-3 pt-3 text-white min-vh-100 w-100">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none w-100 mb-4">
            <span class="fs-5 d-flex align-items-center">
                <span class="d-none d-md-inline"><i class="fas fa-motorcycle me-2"></i></span>
                MyBikeStore
            </span>
        </a>

        <!-- Sidebar Menu -->
        <ul class="nav nav-pills flex-column mb-auto w-100" id="menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt d-none d-md-inline"></i>
                    <span class="d-inline">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.create') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                    <i class="fas fa-tags d-none d-md-inline"></i>
                    <span class="d-inline">Create Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.list') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.list') ? 'active' : '' }}">
                    <i class="fas fa-list d-none d-md-inline"></i>
                    <span class="d-inline">View Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <i class="fas fa-tasks d-none d-md-inline"></i>
                    <span class="d-inline">Manage Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.customers') }}"
                    class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="fas fa-users d-none d-md-inline"></i>
                    <span class="d-inline">Customers</span>
                </a>
            </li>
        </ul>

        @include('partials.user-profile-dropdown')
    </div>
</div>
