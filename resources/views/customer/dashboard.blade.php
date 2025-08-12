@push('scripts')
    <x-customer-loader />
@endpush

@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="main-content">

                <!-- Welcome Hero Section -->
                <div class="welcome-hero">
                    <div class="hero-content">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="welcome-text">
                                    <h1 class="hero-title">
                                        Welcome back, <span class="text-gradient">{{ Auth::user()->name }}</span>! 👋
                                    </h1>
                                    <p class="hero-subtitle">
                                        Ready to build your dream bike? Let's create something amazing together.
                                    </p>
                                    <div class="hero-actions">
                                        <a href="{{ route('customer.bike-builder') }}"
                                            class="btn btn-primary btn-lg hero-btn">
                                            <i class="fas fa-tools me-2"></i>Start Building
                                            <span class="btn-glow"></span>
                                        </a>
                                        <a href="{{ route('customer.orders.history') }}"
                                            class="btn btn-outline-light btn-lg ms-3">
                                            <i class="fas fa-history me-2"></i>View History
                                            <span class="btn-glow"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="hero-illustration">
                                    <div class="floating-bike">
                                        <i class="fas fa-motorcycle"></i>
                                    </div>
                                    <div class="floating-parts">
                                        <div class="part part-1"><i class="fas fa-cog"></i></div>
                                        <div class="part part-2"><i class="fas fa-wrench"></i></div>
                                        <div class="part part-3"><i class="fas fa-bolt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-background">
                        <div class="bg-shape shape-1"></div>
                        <div class="bg-shape shape-2"></div>
                        <div class="bg-shape shape-3"></div>
                    </div>
                </div>

                <!-- Enhanced Stats Cards -->
                <div class="stats-section">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card total-orders-card">
                                <div class="card-decoration"></div>
                                <div class="stat-content">
                                    <div class="stat-header">
                                        <div class="stat-icon">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div class="stat-trend positive">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>+5.2%</span>
                                        </div>
                                    </div>
                                    <div class="stat-body">
                                        <h3 class="stat-number">{{ $stats['total_orders'] }}</h3>
                                        <p class="stat-label">Total Orders</p>
                                        <div class="stat-progress">
                                            <div class="progress-bar total-progress"></div>
                                        </div>
                                        <p class="stat-description">All time orders placed</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card pending-orders-card">
                                <div class="card-decoration"></div>
                                <div class="stat-content">
                                    <div class="stat-header">
                                        <div class="stat-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="stat-trend neutral">
                                            <i class="fas fa-minus"></i>
                                            <span>0%</span>
                                        </div>
                                    </div>
                                    <div class="stat-body">
                                        <h3 class="stat-number">{{ $stats['pending_orders'] }}</h3>
                                        <p class="stat-label">Pending Orders</p>
                                        <div class="stat-progress">
                                            <div class="progress-bar pending-progress"></div>
                                        </div>
                                        <p class="stat-description">Awaiting processing</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card completed-orders-card">
                                <div class="card-decoration"></div>
                                <div class="stat-content">
                                    <div class="stat-header">
                                        <div class="stat-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="stat-trend positive">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>+12%</span>
                                        </div>
                                    </div>
                                    <div class="stat-body">
                                        <h3 class="stat-number">{{ $stats['completed_orders'] }}</h3>
                                        <p class="stat-label">Completed Orders</p>
                                        <div class="stat-progress">
                                            <div class="progress-bar completed-progress"></div>
                                        </div>
                                        <p class="stat-description">Successfully delivered</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Recent Orders Section -->
                <div class="orders-section">
                    <div class="section-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="section-title">
                                    <i class="fas fa-history me-2"></i>Recent Orders
                                </h3>
                                <p class="section-subtitle">Track your recent bike building orders</p>
                            </div>
                            <div class="col-md-6 text-md-end">

                                <a href="{{ route('customer.bike-builder') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>New Order
                                    <span class="btn-glow"></span>
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="orders-content">
                        @if ($recentOrders->count() > 0)
                            <div class="orders-grid">
                                @foreach ($recentOrders as $index => $order)
                                    <div class="order-card" style="animation-delay: {{ $index * 0.1 }}s">
                                        <div class="order-header">
                                            <div class="order-id">
                                                <span class="id-label">Order</span>
                                                <span class="id-number">#{{ $order->id }}</span>
                                            </div>
                                            <div class="order-status">
                                                <span class="status-badge status-{{ $order->status }}">
                                                    @if ($order->status == 'completed')
                                                        <i class="fas fa-check-circle me-1"></i>
                                                    @else
                                                        <i class="fas fa-clock me-1"></i>
                                                    @endif
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="order-body">
                                            <div class="order-info">
                                                <div class="info-item">
                                                    <span class="info-label">Date</span>
                                                    <span
                                                        class="info-value">{{ $order->created_at->format('d M Y') }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Items</span>
                                                    <span class="info-value">{{ $order->items_count }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Total</span>
                                                    <span
                                                        class="info-value amount">${{ number_format($order->total_amount, 2) }}</span>
                                                </div>
                                            </div>

                                            <div class="order-progress">
                                                <div class="progress-track">
                                                    <div
                                                        class="progress-fill {{ $order->status == 'completed' ? 'completed' : 'pending' }}">
                                                    </div>
                                                </div>
                                                <div class="progress-steps">
                                                    <div class="step {{ $order->status != 'pending' ? 'active' : '' }}">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </div>
                                                    <div class="step {{ $order->status == 'completed' ? 'active' : '' }}">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-footer">
                                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="orders-footer">
                                <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-1"></i>View All Orders
                                </a>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-illustration">
                                    <div class="empty-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div class="empty-particles">
                                        <div class="particle"></div>
                                        <div class="particle"></div>
                                        <div class="particle"></div>
                                    </div>
                                </div>
                                <div class="empty-content">
                                    <h4 class="empty-title">No Orders Yet</h4>
                                    <p class="empty-description">
                                        Start your bike building journey by creating your first custom order
                                    </p>
                                    <a href="{{ route('customer.bike-builder') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-tools me-2"></i>Build Your First Bike
                                        <span class="btn-glow"></span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Professional Customer Dashboard Styles */
            .main-content {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                padding: 2rem;
                position: relative;
            }

            /* Welcome Hero Section */
            .welcome-hero {
                position: relative;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 25px;
                padding: 3rem;
                margin-bottom: 2rem;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .hero-content {
                position: relative;
                z-index: 2;
            }

            .hero-title {
                font-size: 3rem;
                font-weight: 700;
                color: white;
                margin-bottom: 1rem;
                line-height: 1.2;
            }

            .text-gradient {
                background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero-subtitle {
                font-size: 1.25rem;
                color: rgba(255, 255, 255, 0.8);
                margin-bottom: 2rem;
                line-height: 1.5;
            }

            .hero-actions {
                display: flex;
                gap: 1rem;
                align-items: center;
            }

            .hero-btn {
                position: relative;
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                border: none;
                padding: 1rem 2rem;
                border-radius: 50px;
                font-weight: 600;
                transition: all 0.3s ease;
                overflow: hidden;
            }

            .hero-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
            }

            .btn-glow {
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .hero-btn:hover .btn-glow {
                left: 100%;
            }

            .hero-illustration {
                text-align: center;
                position: relative;
            }

            .floating-bike {
                width: 120px;
                height: 120px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 2rem;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                animation: float 3s ease-in-out infinite;
            }

            .floating-bike i {
                font-size: 3rem;
                color: #fbbf24;
            }

            .floating-parts {
                position: relative;
            }

            .part {
                position: absolute;
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                color: white;
            }

            .part-1 {
                top: -20px;
                left: 20px;
                animation: float 2s ease-in-out infinite;
            }

            .part-2 {
                top: 20px;
                right: 10px;
                animation: float 2.5s ease-in-out infinite reverse;
            }

            .part-3 {
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                animation: float 3s ease-in-out infinite;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .hero-background {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                overflow: hidden;
            }

            .bg-shape {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.05);
            }

            .shape-1 {
                width: 200px;
                height: 200px;
                top: -50px;
                right: -50px;
                animation: rotate 20s linear infinite;
            }

            .shape-2 {
                width: 150px;
                height: 150px;
                bottom: -30px;
                left: -30px;
                animation: rotate 15s linear infinite reverse;
            }

            .shape-3 {
                width: 100px;
                height: 100px;
                top: 50%;
                right: 20%;
                animation: rotate 25s linear infinite;
            }

            @keyframes rotate {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            /* Enhanced Stats Section */
            .stats-section {
                margin-bottom: 2rem;
            }

            .stat-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2rem;
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
                height: 240px;
                animation: slideUp 0.6s ease-out;
            }

            .stat-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            .card-decoration {
                position: absolute;
                top: 0;
                right: 0;
                width: 100px;
                height: 100px;
                border-radius: 0 20px 0 100px;
                opacity: 0.1;
            }

            .total-orders-card .card-decoration {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            }

            .pending-orders-card .card-decoration {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            }

            .completed-orders-card .card-decoration {
                background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            }

            .stat-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
            }

            .total-orders-card .stat-icon {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            }

            .pending-orders-card .stat-icon {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            }

            .completed-orders-card .stat-icon {
                background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            }

            .stat-trend {
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            .stat-trend.positive {
                background: rgba(16, 185, 129, 0.1);
                color: #10b981;
            }

            .stat-trend.neutral {
                background: rgba(107, 114, 128, 0.1);
                color: #6b7280;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }

            .stat-label {
                font-size: 1rem;
                font-weight: 600;
                color: #6b7280;
                margin-bottom: 1rem;
            }

            .stat-progress {
                width: 100%;
                height: 6px;
                background: #e5e7eb;
                border-radius: 3px;
                overflow: hidden;
                margin-bottom: 1rem;
            }

            .progress-bar {
                height: 100%;
                border-radius: 3px;
                animation: progressLoad 2s ease-out;
            }

            .total-progress {
                width: 85%;
                background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%);
            }

            .pending-progress {
                width: 60%;
                background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
            }

            .completed-progress {
                width: 90%;
                background: linear-gradient(90deg, #10b981 0%, #047857 100%);
            }

            .stat-description {
                color: #9ca3af;
                font-size: 0.875rem;
                margin: 0;
            }

            /* Orders Section */
            .orders-section {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 25px;
                padding: 2rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .section-header {
                margin-bottom: 2rem;
            }

            .section-title {
                font-size: 1.75rem;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }

            .section-subtitle {
                color: #6b7280;
                margin: 0;
            }

            .orders-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .order-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                border: 1px solid #e5e7eb;
                transition: all 0.3s ease;
                animation: slideUp 0.6s ease-out;
            }

            .order-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border-color: #3b82f6;
            }

            .order-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .order-id {
                display: flex;
                flex-direction: column;
            }

            .id-label {
                font-size: 0.75rem;
                color: #9ca3af;
                text-transform: uppercase;
                font-weight: 600;
            }

            .id-number {
                font-size: 1.125rem;
                font-weight: 700;
                color: #1f2937;
            }

            .status-badge {
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                display: flex;
                align-items: center;
            }

            .status-completed {
                background: rgba(16, 185, 129, 0.1);
                color: #10b981;
            }

            .status-pending {
                background: rgba(245, 158, 11, 0.1);
                color: #f59e0b;
            }

            .order-info {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
                margin-bottom: 1.5rem;
            }

            .info-item {
                text-align: center;
            }

            .info-label {
                display: block;
                font-size: 0.75rem;
                color: #9ca3af;
                text-transform: uppercase;
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .info-value {
                font-size: 1rem;
                font-weight: 600;
                color: #1f2937;
            }

            .info-value.amount {
                color: #10b981;
            }

            .order-progress {
                margin-bottom: 1.5rem;
            }

            .progress-track {
                height: 4px;
                background: #e5e7eb;
                border-radius: 2px;
                position: relative;
                margin-bottom: 1rem;
            }

            .progress-fill {
                height: 100%;
                border-radius: 2px;
                transition: width 1s ease-out;
            }

            .progress-fill.completed {
                width: 100%;
                background: linear-gradient(90deg, #10b981 0%, #047857 100%);
            }

            .progress-fill.pending {
                width: 50%;
                background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
            }

            .progress-steps {
                display: flex;
                justify-content: space-between;
            }

            .step {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: #e5e7eb;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #9ca3af;
                transition: all 0.3s ease;
            }

            .step.active {
                background: #10b981;
                color: white;
            }

            .order-footer {
                display: flex;
                gap: 0.75rem;
            }

            .order-footer .btn {
                flex: 1;
            }

            .orders-footer {
                text-align: center;
                padding-top: 2rem;
                border-top: 1px solid #e5e7eb;
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
            }

            .empty-illustration {
                position: relative;
                margin-bottom: 2rem;
            }

            .empty-icon {
                width: 120px;
                height: 120px;
                background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                font-size: 3rem;
                color: #9ca3af;
                animation: float 3s ease-in-out infinite;
            }

            .empty-particles {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
            }

            .particle {
                position: absolute;
                width: 8px;
                height: 8px;
                background: #d1d5db;
                border-radius: 50%;
                animation: float 2s ease-in-out infinite;
            }

            .particle:nth-child(1) {
                top: 20px;
                left: 20px;
                animation-delay: 0s;
            }

            .particle:nth-child(2) {
                top: 30px;
                right: 30px;
                animation-delay: 0.5s;
            }

            .particle:nth-child(3) {
                bottom: 40px;
                left: 50%;
                animation-delay: 1s;
            }

            .empty-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 1rem;
            }

            .empty-description {
                color: #6b7280;
                font-size: 1.1rem;
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            /* Animations */
            @keyframes slideUp {
                0% {
                    opacity: 0;
                    transform: translateY(30px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes progressLoad {
                0% {
                    width: 0;
                }
            }

            /* Mobile Responsiveness */
            @media (max-width: 768px) {
                .main-content {
                    padding: 1rem;
                }

                .welcome-hero {
                    padding: 2rem 1.5rem;
                }

                .hero-title {
                    font-size: 2rem;
                }

                .hero-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .orders-grid {
                    grid-template-columns: 1fr;
                }

                .order-info {
                    grid-template-columns: 1fr;
                    gap: 0.75rem;
                }

                .section-header .row {
                    flex-direction: column;
                    gap: 1rem;
                }

                .section-header .col-md-6:last-child {
                    text-align: left !important;
                }
            }
        </style>
    @endpush
@endsection
