<div class="collapse d-md-flex col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" id="sidebar">
    <!-- Mobile Close Button -->
    <div class="d-flex justify-content-end p-2 d-md-none">
        <button class="btn btn-sm btn-danger" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}"
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
                <a href="{{ route('admin.dashboard') }}" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 fas fa-tachometer-alt"></i>
                    <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
            </li>

            <!-- Part Categories -->
            <li class="nav-item w-100 mt-2">
                <a href="{{ route('admin.categories.create') }}" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 fas fa-tags"></i>
                    <span class="ms-1 d-none d-sm-inline">Create Category</span>
                </a>
            </li>

            <!-- View Categories (new link) -->
            <li class="nav-item w-100 mt-2">
                <a href="{{ route('admin.categories.list') }}" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 fas fa-list"></i>
                    <span class="ms-1 d-none d-sm-inline">View Categories</span>
                </a>
            </li>

            <!-- Orders -->
            <li class="nav-item w-100 mt-2">
                <a href="{{ route('admin.orders.index') }}" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 fas fa-tasks"></i>
                    <span class="ms-1 d-none d-sm-inline">Manage Orders</span>
                </a>
            </li>

            <!-- Customers -->
            <li class="nav-item w-100 mt-2">
                <a href="{{ route('admin.customers') }}" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 fas fa-users"></i>
                    <span class="ms-1 d-none d-sm-inline">Customers</span>
                </a>
            </li>
        </ul>

        @include('partials.user-profile-dropdown')
    </div>
</div>
