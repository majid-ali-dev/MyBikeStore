<div class="sidebar" id="sidebar">
    <!-- Close Button (Mobile) -->
    <button class="sidebar-close" id="sidebarClose">
        <i class="fas fa-times"></i>
    </button>

    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('customer.dashboard') }}" class="text-decoration-none">
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
                <a href="{{ route('customer.dashboard') }}"
                    class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.bike-builder') }}"
                    class="nav-link {{ request()->routeIs('customer.bike-builder') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i>
                    <span>Build Your Bike</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders') }}"
                    class="nav-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.orders.history') }}"
                    class="nav-link {{ request()->routeIs('customer.orders.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Order History</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Profile Section -->
    <div class="sidebar-footer">
        <div class="profile-dropdown">
            <button class="profile-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                    @if (Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Profile"
                            class="rounded-circle">
                    @else
                        <div class="avatar-initials">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="profile-info">
                    <h6>{{ Auth::user()->name }}</h6>
                    <span>{{ Auth::user()->email }}</span>
                </div>
                <i class="fas fa-chevron-down ms-auto"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark w-100">
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <i class="fas fa-user-circle me-2"></i>View Profile
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
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

<!-- Profile View Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">My Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    @if (Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                            class="rounded-circle img-thumbnail" width="120" height="120">
                    @else
                        <div class="profile-initials-lg mx-auto">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    @if (Auth::user()->phone)
                        <h4 class="mt-3">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                    @endif
                </div>

                <div class="profile-details">
                    <div class="detail-item">
                        <span class="detail-label">Member Since</span>
                        <span class="detail-value">
                            {{ Auth::user()->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-initials {
        font-weight: bold;
        color: #555;
    }

    .profile-initials-lg {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        color: #555;
    }

    .profile-details {
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .detail-label {
        font-weight: 500;
        color: #666;
    }

    .detail-value {
        color: #333;
    }
</style>
</div>
