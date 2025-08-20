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
            <li class="nav-item">
                <a class="nav-link" href="{{ route('customer.live-chat') }}">
                    <i class="fas fa-comment-medical me-2"></i>
                    <span>Chat</span>
                    <span class="badge bg-danger float-end">New</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.about_us') }}"
                    class="nav-link {{ request()->routeIs('customer.about_us') ? 'active' : '' }}">
                    <i class="fas fa-info"></i>
                    <span>About Us</span>
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

<!-- Enhanced Profile View Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header with Gradient Background -->
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="profileModalLabel">
                    <i class="fas fa-user-circle me-2"></i>
                    My Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Profile Header Section -->
                <div class="text-center mb-4">
                    @if (Auth::user()->profile_photo_path)
                        <div class="profile-photo-container position-relative d-inline-block">
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                class="rounded-circle img-thumbnail shadow" width="120" height="120"
                                alt="Profile Photo">
                            <div class="position-absolute bottom-0 end-0">
                                <span class="badge bg-success rounded-pill">
                                    <i class="fas fa-check"></i>
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="profile-initials-lg mx-auto shadow-sm border">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    <h4 class="mt-3 mb-1 fw-bold text-primary">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-0">
                        <i class="fas fa-envelope me-1"></i>
                        {{ Auth::user()->email }}
                    </p>
                    @if (Auth::user()->phone)
                        <p class="text-muted mb-0">
                            <i class="fas fa-phone me-1"></i>
                            {{ Auth::user()->phone }}
                        </p>
                    @endif

                    <!-- User Status Badge -->
                    <div class="mt-2">
                        <span class="badge bg-success px-3 py-2">
                            <i class="fas fa-user-check me-1"></i>
                            Verified Customer
                        </span>
                    </div>
                </div>

                <!-- Profile Details Cards -->
                <div class="row g-3">
                    <!-- Account Information Card -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light border-0">
                                <h6 class="mb-0 fw-bold text-primary">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Account Information
                                </h6>
                            </div>

                            <div class="card-body">

                                {{-- Member Since --}}
                                <div class="detail-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-calendar-alt me-2"></i>Member Since
                                        </span>
                                        <span class="detail-value fw-bold">
                                            {{ Auth::user()->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Current Login --}}
                                <div class="detail-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-clock me-2"></i>Current Login
                                        </span>
                                        <span class="detail-value fw-bold">
                                            {{ now()->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>


                                <div class="detail-item mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-shield-alt me-2"></i>Account Status
                                        </span>
                                        <span class="detail-value">
                                            <span class="badge bg-success">Active</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Statistics Card -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light border-0">
                                <h6 class="mb-0 fw-bold text-primary">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Order Statistics
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="detail-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-shopping-cart me-2"></i>Total Orders
                                        </span>
                                        <span class="detail-value fw-bold text-primary">
                                            {{ Auth::user()->orders()->count() }}
                                        </span>
                                    </div>
                                </div>

                                <div class="detail-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-clock me-2"></i>Pending Orders
                                        </span>
                                        <span class="detail-value fw-bold text-warning">
                                            {{ Auth::user()->orders()->whereIn('status', ['pending', 'processing'])->count() }}
                                        </span>
                                    </div>
                                </div>

                                <div class="detail-item mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-check-circle me-2"></i>Completed Orders
                                        </span>
                                        <span class="detail-value fw-bold text-success">
                                            {{ Auth::user()->orders()->whereIn('status', ['completed', 'delivered'])->count() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Row -->
                <div class="row g-3 mt-2">
                    <!-- Contact Information Card -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0">
                                <h6 class="mb-0 fw-bold text-primary">
                                    <i class="fas fa-address-book me-2"></i>
                                    Contact Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="detail-item mb-2">
                                    <span class="detail-label text-muted d-block">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </span>
                                    <span class="detail-value">{{ Auth::user()->email }}</span>
                                </div>

                                @if (Auth::user()->phone)
                                    <div class="detail-item mb-2">
                                        <span class="detail-label text-muted d-block">
                                            <i class="fas fa-phone me-2"></i>Phone Number
                                        </span>
                                        <span class="detail-value">{{ Auth::user()->phone }}</span>
                                    </div>
                                @else
                                    <div class="detail-item mb-2">
                                        <span class="detail-label text-muted d-block">
                                            <i class="fas fa-phone me-2"></i>Phone Number
                                        </span>
                                        <span class="detail-value text-muted">Not provided</span>
                                    </div>
                                @endif

                                @if (Auth::user()->address)
                                    <div class="detail-item mb-0">
                                        <span class="detail-label text-muted d-block">
                                            <i class="fas fa-map-marker-alt me-2"></i>Address
                                        </span>
                                        <span class="detail-value">{{ Auth::user()->address }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Account Security Card -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0">
                                <h6 class="mb-0 fw-bold text-primary">
                                    <i class="fas fa-lock me-2"></i>
                                    Account Security
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="detail-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-key me-2"></i>Password
                                        </span>
                                        <span class="detail-value">
                                            <span class="badge bg-success">Secured</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="detail-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-user-shield me-2"></i>Role
                                        </span>
                                        <span class="detail-value">
                                            <span
                                                class="badge bg-info text-capitalize">{{ Auth::user()->role }}</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="detail-item mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="detail-label text-muted">
                                            <i class="fas fa-shield-alt me-2"></i>Two-Factor Auth
                                        </span>
                                        <span class="detail-value">
                                            <span class="badge bg-warning">Not Enabled</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Modal Footer -->
            <div class="modal-footer border-0 pt-0">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Profile information is secure and private
                        </small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional CSS for Enhanced Styling -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .profile-initials-lg {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .profile-photo-container::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        border-radius: 50%;
        background: linear-gradient(45deg, #007bff, #0056b3);
        z-index: -1;
    }

    .detail-item {
        padding: 8px 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        border-radius: 15px 15px 0 0;
    }
</style>
</div>
