<div class="sidebar" id="sidebar">
    <!-- Close Button (Mobile) -->
    <button class="sidebar-close" id="sidebarClose">
        <i class="fas fa-times"></i>
    </button>

    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
            <h4>
                <div class="brand-icon">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <span class="brand-text">MyBikeStore</span>
            </h4>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.create') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Create Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.list') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.list') ? 'active' : '' }}">
                    <i class="fas fa-list-ul"></i>
                    <span>View Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Manage Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.customers') }}"
                    class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Profile Section -->
    <div class="sidebar-footer">
        <div class="profile-dropdown">
            <button class="profile-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h6>{{ Auth::user()->name ?? 'Admin' }}</h6>
                    <span>{{ Auth::user()->email ?? 'admin@example.com' }}</span>
                </div>
                <i class="fas fa-chevron-up ms-auto"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark w-100">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
