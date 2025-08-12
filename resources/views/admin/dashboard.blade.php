@push('scripts')
    <x-admin-loader />
@endpush

@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <!-- Mobile Toggle Button -->
                <button class="btn btn-dark d-md-none mb-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Dashboard Header with Welcome Message -->
                <div class="dashboard-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="welcome-section">
                                <h1 class="display-6 fw-bold text-gradient mb-1">Admin Dashboard</h1>
                                <p class="text-muted fs-5 mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>{{ date('l, F j, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="dashboard-actions">
                                <a href="{{ route('admin.orders.download_all_delivered') }}"
                                    class="btn btn-outline-primary me-2">
                                    <i class="fas fa-download me-1"></i>Export Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Dashboard Cards with Animations -->
                <div class="row g-4 mb-4">
                    <!-- Customers Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card customers-card">
                            <div class="card-content">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-trend">
                                        <span class="trend-up">
                                            <i class="fas fa-arrow-up"></i> 12%
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-body">
                                    <h3 class="stat-number">{{ $totalCustomers }}</h3>
                                    <p class="stat-label">Total Customers</p>
                                    <div class="progress-bar">
                                        <div class="progress-fill customers-progress"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-overlay customers-overlay"></div>
                        </div>
                    </div>

                    <!-- Brands Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card brands-card">
                            <div class="card-content">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-motorcycle"></i>
                                    </div>
                                    <div class="stat-trend">
                                        <span class="trend-up">
                                            <i class="fas fa-arrow-up"></i> 8%
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-body">
                                    <h3 class="stat-number">{{ $totalBikes }}</h3>
                                    <p class="stat-label">Total Brands</p>
                                    <div class="progress-bar">
                                        <div class="progress-fill brands-progress"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-overlay brands-overlay"></div>
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card categories-card">
                            <div class="card-content">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="stat-trend">
                                        <span class="trend-up">
                                            <i class="fas fa-arrow-up"></i> 15%
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-body">
                                    <h3 class="stat-number">{{ $totalCategories }}</h3>
                                    <p class="stat-label">Total Categories</p>
                                    <div class="progress-bar">
                                        <div class="progress-fill categories-progress"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-overlay categories-overlay"></div>
                        </div>
                    </div>

                    <!-- Parts Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card parts-card">
                            <div class="card-content">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-puzzle-piece"></i>
                                    </div>
                                    <div class="stat-trend">
                                        <span class="trend-up">
                                            <i class="fas fa-arrow-up"></i> 20%
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-body">
                                    <h3 class="stat-number">{{ $totalParts }}</h3>
                                    <p class="stat-label">Total Parts</p>
                                    <div class="progress-bar">
                                        <div class="progress-fill parts-progress"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-overlay parts-overlay"></div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Customers Table -->
                <div class="data-table-card">
                    <div class="table-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="table-title">
                                    <i class="fas fa-users me-2"></i>Customer Management
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="table-actions">
                                    <div class="search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" id="customerSearch" placeholder="Search customers..."
                                            class="form-control" wire:model.debounce.500ms="search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-body">
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="th-content">
                                                <span>ID</span>
                                                <i class="fas fa-sort"></i>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="th-content">
                                                <span>Customer</span>
                                                <i class="fas fa-sort"></i>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="th-content">
                                                <span>Contact</span>
                                                <i class="fas fa-sort"></i>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="th-content">
                                                <span>Phone</span>
                                                <i class="fas fa-sort"></i>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="th-content">
                                                <span>Joined</span>
                                                <i class="fas fa-sort"></i>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr class="table-row">
                                            <td>
                                                <span class="customer-id">#{{ $customer->id }}</span>
                                            </td>
                                            <td>
                                                <div class="customer-info">
                                                    <div class="customer-avatar">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=6366f1&color=ffffff"
                                                            alt="{{ $customer->name }}" class="avatar-img">
                                                    </div>
                                                    <div class="customer-details">
                                                        <span class="customer-name">{{ $customer->name }}</span>
                                                        <span class="customer-role">Customer</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <i class="fas fa-envelope text-muted me-1"></i>
                                                    <span>{{ $customer->email }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="phone-info">
                                                    @if ($customer->phone)
                                                        <i class="fas fa-phone text-muted me-1"></i>
                                                        <span>{{ $customer->phone }}</span>
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <span
                                                        class="date">{{ $customer->created_at->format('d M Y') }}</span>
                                                    <span
                                                        class="time text-muted">{{ $customer->created_at->format('H:i') }}</span>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {{ $customers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <style>
            /* Professional Dashboard Styles */
            .main-content {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                padding: 2rem;
            }

            .text-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .dashboard-header {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }

            /* Enhanced Stat Cards */
            .stat-card {
                position: relative;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 1.5rem;
                height: 200px;
                overflow: hidden;
                transition: all 0.3s ease;
                cursor: pointer;
                border: 1px solid rgba(255, 255, 255, 0.18);
            }

            .stat-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(31, 38, 135, 0.2);
            }

            .card-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                opacity: 0.1;
                transition: opacity 0.3s ease;
            }

            .customers-overlay {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .brands-overlay {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            }

            .categories-overlay {
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            }

            .parts-overlay {
                background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            }

            .stat-card:hover .card-overlay {
                opacity: 0.2;
            }

            .stat-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: white;
            }

            .customers-card .stat-icon {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .brands-card .stat-icon {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            }

            .categories-card .stat-icon {
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            }

            .parts-card .stat-icon {
                background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            }

            .stat-trend {
                background: rgba(34, 197, 94, 0.1);
                color: #22c55e;
                padding: 0.25rem 0.5rem;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                margin: 0;
                background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .stat-label {
                color: #64748b;
                font-weight: 500;
                margin: 0;
                font-size: 0.875rem;
            }

            .progress-bar {
                width: 100%;
                height: 6px;
                background: rgba(148, 163, 184, 0.2);
                border-radius: 3px;
                margin-top: 1rem;
                overflow: hidden;
            }

            .progress-fill {
                height: 100%;
                border-radius: 3px;
                animation: progressLoad 2s ease-out;
            }

            .customers-progress {
                width: 85%;
                background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            }

            .brands-progress {
                width: 70%;
                background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            }

            .categories-progress {
                width: 60%;
                background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            }

            .parts-progress {
                width: 90%;
                background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            }

            @keyframes progressLoad {
                0% {
                    width: 0;
                }
            }

            /* Enhanced Table Styles */
            .data-table-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }

            .table-header {
                padding: 2rem;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .table-title {
                margin: 0;
                font-weight: 600;
            }

            .table-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }

            .search-box {
                position: relative;
                width: 300px;
            }

            .search-box i {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: #9ca3af;
            }

            .search-box input {
                padding-left: 2.5rem;
                border: none;
                border-radius: 50px;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(10px);
                color: white;
                height: 45px;
            }

            .search-box input::placeholder {
                color: rgba(255, 255, 255, 0.7);
            }

            .search-box input:focus {
                background: rgba(255, 255, 255, 0.3);
                box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            }

            .table-body {
                padding: 0;
            }

            .modern-table {
                margin: 0;
            }

            .modern-table thead th {
                background: #f8fafc;
                border: none;
                padding: 1.5rem 1rem;
                font-weight: 600;
                color: #475569;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .th-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .th-content i {
                opacity: 0.5;
                transition: opacity 0.2s;
            }

            .th-content:hover i {
                opacity: 1;
            }

            .modern-table tbody tr {
                border: none;
                transition: all 0.2s ease;
            }

            .modern-table tbody tr:hover {
                background: rgba(99, 102, 241, 0.05);
                transform: scale(1.01);
            }

            .modern-table tbody td {
                padding: 1.5rem 1rem;
                border: none;
                vertical-align: middle;
            }

            .customer-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .customer-avatar {
                position: relative;
            }

            .avatar-img {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid #e2e8f0;
            }

            .customer-details {
                display: flex;
                flex-direction: column;
            }

            .customer-name {
                font-weight: 600;
                color: #1e293b;
                font-size: 0.9rem;
            }

            .customer-role {
                font-size: 0.75rem;
                color: #64748b;
                background: #f1f5f9;
                padding: 0.125rem 0.5rem;
                border-radius: 12px;
                width: fit-content;
            }

            .customer-id {
                font-weight: 600;
                color: #6366f1;
            }

            .contact-info,
            .phone-info {
                display: flex;
                align-items: center;
                color: #475569;
                font-size: 0.875rem;
            }

            .date-info {
                display: flex;
                flex-direction: column;
            }

            .date {
                font-weight: 500;
                color: #1e293b;
            }

            .time {
                font-size: 0.75rem;
            }

            /* Updated Action Buttons */
            .action-buttons {
                min-height: 60px;
            }

            .btn-action {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                padding: 0;
                transition: all 0.2s ease;
            }

            .btn-action:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .pagination-wrapper {
                padding: 2rem;
                background: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }

            /* Mobile Responsiveness */
            @media (max-width: 768px) {
                .main-content {
                    padding: 1rem;
                }

                .dashboard-header {
                    padding: 1.5rem;
                }

                .stat-card {
                    height: auto;
                    padding: 1.25rem;
                }

                .table-header {
                    padding: 1.5rem;
                }

                .table-actions {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: stretch;
                }

                .search-box {
                    width: 100%;
                }

                .customer-info {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }
            }

            /* Animation for cards */
            .stat-card {
                animation: slideUp 0.6s ease-out;
            }

            .stat-card:nth-child(1) {
                animation-delay: 0.1s;
            }

            .stat-card:nth-child(2) {
                animation-delay: 0.2s;
            }

            .stat-card:nth-child(3) {
                animation-delay: 0.3s;
            }

            .stat-card:nth-child(4) {
                animation-delay: 0.4s;
            }

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
        </style>
    @endpush

    @push('scripts')
        <script>
            // Live search functionality
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('customerSearch');
                const tableRows = document.querySelectorAll('.table-row');

                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            });
        </script>
    @endpush
@endsection
