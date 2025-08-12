@extends('layouts.app')
@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.admin-sidebar')
            <!-- Main Content -->
            <div class="main-content">
                <!-- Enhanced Dashboard Header -->
                <div class="dashboard-header mb-4 position-relative overflow-hidden">
                    <div class="header-background"></div>
                    <div class="row align-items-center position-relative z-index-2">
                        <div class="col-md-8">
                            <div class="welcome-section">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="header-icon me-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h1 class="display-6 fw-bold text-white mb-1">Customer Management</h1>
                                        <p class="text-white-50 fs-5 mb-0">
                                            Manage and monitor all your customers efficiently
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="stats-cards d-flex gap-2">
                                <div class="stat-card">
                                    <div class="stat-number">{{ $customers->total() ?? count($customers) }}</div>
                                    <div class="stat-label">Total Customers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Customers Table -->
                <div class="data-table-card shadow-lg">
                    <div class="table-header p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="table-title mb-0">
                                    <i class="fas fa-users me-2 text-primary"></i>All Customers
                                    <span class="badge bg-primary ms-2">{{ $customers->count() }}</span>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="table-actions d-flex gap-2 justify-content-end">
                                    <div class="search-box position-relative">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" id="customerSearch" placeholder="Search customers..."
                                            class="form-control ps-5" wire:model.debounce.500ms="search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-body">
                        @if ($customers->isEmpty())
                            <div class="empty-state text-center py-5">
                                <div class="empty-icon mb-3">
                                    <i class="fas fa-users fa-4x text-muted opacity-25"></i>
                                </div>
                                <h5 class="text-muted mb-2">No customers found</h5>
                                <p class="text-muted">Start by adding your first customer or adjust your search filters.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table modern-table mb-0">
                                    <thead class="table-header-modern">
                                        <tr>
                                            <th class="sortable" data-sort="id">
                                                <div class="d-flex align-items-center">
                                                    ID <i class="fas fa-sort ms-1 text-muted"></i>
                                                </div>
                                            </th>
                                            <th class="sortable" data-sort="name">
                                                <div class="d-flex align-items-center">
                                                    Name <i class="fas fa-sort ms-1 text-muted"></i>
                                                </div>
                                            </th>
                                            <th class="sortable" data-sort="email">
                                                <div class="d-flex align-items-center">
                                                    Email <i class="fas fa-sort ms-1 text-muted"></i>
                                                </div>
                                            </th>
                                            <th>Phone</th>
                                            <th class="sortable" data-sort="date">
                                                <div class="d-flex align-items-center">
                                                    Registered <i class="fas fa-sort ms-1 text-muted"></i>
                                                </div>
                                            </th>
                                            <th class="text-center">Orders</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customerTableBody">
                                        @foreach ($customers as $customer)
                                            <tr class="customer-row table-row-hover" data-customer-id="{{ $customer->id }}">
                                                <td>
                                                    <span
                                                        class="customer-id">#{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </td>
                                                <td>
                                                    <div class="customer-info d-flex align-items-center">
                                                        <div class="customer-avatar me-3">
                                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="customer-name fw-semibold">{{ $customer->name }}
                                                            </div>
                                                            <small class="text-muted">Customer</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="email-wrapper">
                                                        <i class="fas fa-envelope text-muted me-1"></i>
                                                        <span class="email-text">{{ $customer->email }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($customer->phone)
                                                        <div class="phone-wrapper">
                                                            <i class="fas fa-phone text-muted me-1"></i>
                                                            <span>{{ $customer->phone }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="date-wrapper">
                                                        <div class="registration-date">
                                                            {{ $customer->created_at->format('d M Y') }}</div>
                                                        <small
                                                            class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="order-badge badge bg-gradient-primary rounded-pill px-3 py-2">
                                                        {{ $customer->orders_count }}
                                                        <small class="d-block">orders</small>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action-buttons">
                                                        <button class="btn btn-sm btn-action btn-info view-customer-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewCustomerModal-{{ $customer->id }}"
                                                            title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Enhanced Pagination -->
                                <div class="pagination-wrapper d-flex justify-content-between align-items-center p-4">
                                    <div class="pagination-info">
                                        <span class="text-muted">
                                            Showing {{ $customers->firstItem() ?? 1 }} to
                                            {{ $customers->lastItem() ?? $customers->count() }}
                                            of {{ $customers->total() ?? $customers->count() }} customers
                                        </span>
                                    </div>
                                    <div class="pagination-controls">
                                        {{ $customers->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Customer Detail Modals -->
    @foreach ($customers as $customer)
        <div class="modal fade" id="viewCustomerModal-{{ $customer->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-gradient-primary text-white border-0">
                        <div class="d-flex align-items-center">
                            <div class="modal-customer-avatar me-3">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="modal-title mb-0">{{ $customer->name }}</h5>
                                <small class="opacity-75">Customer ID:
                                    #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card mb-3">
                                    <div class="info-icon">
                                        <i class="fas fa-id-card text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="text-muted mb-1">Customer ID</h6>
                                        <p class="mb-0 fw-semibold">#{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="info-card mb-3">
                                    <div class="info-icon">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="text-muted mb-1">Full Name</h6>
                                        <p class="mb-0 fw-semibold">{{ $customer->name }}</p>
                                    </div>
                                </div>

                                <div class="info-card mb-3">
                                    <div class="info-icon">
                                        <i class="fas fa-envelope text-info"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="text-muted mb-1">Email Address</h6>
                                        <p class="mb-0">{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card mb-3">
                                    <div class="info-icon">
                                        <i class="fas fa-phone text-warning"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="text-muted mb-1">Phone Number</h6>
                                        <p class="mb-0">{{ $customer->phone ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="info-card mb-3">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar text-purple"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="text-muted mb-1">Registration Date</h6>
                                        <p class="mb-0">{{ $customer->created_at->format('F j, Y') }}</p>
                                        <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                                <div class="info-card mb-3">
                                    <div class="info-icon">
                                        <i class="fas fa-shopping-bag text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6 class="text-muted mb-1">Total Orders</h6>
                                        <span class="badge bg-gradient-primary rounded-pill px-3 py-2">
                                            {{ $customer->orders_count }} orders
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($customer->orders_count > 0)
                            <hr class="my-4">
                            <div class="orders-section">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                                    <h5 class="mb-0">Recent Orders</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->orders()->latest()->take(3)->get() as $order)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="fw-semibold">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <span
                                                            class="fw-semibold text-success">${{ number_format($order->total_amount, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="status-badge badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
    <style>
        /* Enhanced Custom Styles */
        .main-content {
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            color: white;
            min-width: 120px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .data-table-card {
            background: white;
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .table-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 2;
        }

        .search-box input {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding-left: 3rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .table-header-modern th {
            background: #f8f9fa;
            border: none;
            padding: 1rem;
            font-weight: 600;
            color: #495057;
            position: relative;
        }

        .sortable {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sortable:hover {
            background: #e9ecef;
        }

        .customer-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .table-row-hover:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .customer-id {
            font-family: monospace;
            font-weight: bold;
            color: #667eea;
        }

        .customer-name {
            color: #2d3748;
        }

        .email-wrapper,
        .phone-wrapper {
            display: flex;
            align-items: center;
        }

        .date-wrapper .registration-date {
            font-weight: 500;
            color: #2d3748;
        }

        .order-badge {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            font-size: 0.75rem;
            min-width: 60px;
        }

        /* Fixed action buttons styling */
        .action-buttons {
            pointer-events: auto;
            position: relative;
            z-index: 10;
        }

        .action-buttons .btn {
            pointer-events: auto;
            position: relative;
            z-index: 15;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Prevent row click when clicking in action buttons area */
        .customer-row .action-buttons::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            z-index: 5;
            pointer-events: auto;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-icon {
            opacity: 0.3;
        }

        .modal-customer-avatar {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .info-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-right: 1rem;
            background: white;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
        }

        .text-purple {
            color: #764ba2 !important;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
        }

        .orders-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
        }

        .pagination-wrapper {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .dashboard-header {
                padding: 1.5rem;
            }

            .table-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .search-box {
                width: 100%;
            }

            .stat-card {
                margin-bottom: 1rem;
            }
        }

        /* Animation for loading states */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .customer-row {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }

        .custom-tooltip .tooltip-inner {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 8px;
            padding: 8px 12px;
        }

        /* Print styles */
        @media print {

            .btn,
            .dropdown,
            .search-box,
            .pagination-wrapper {
                display: none !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced alert dismissal
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                });
            }, 5000);

            // Initialize tooltips with custom styling
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    customClass: 'custom-tooltip'
                });
            });

            // Enhanced live search functionality
            const searchInput = document.getElementById('customerSearch');
            const customerRows = document.querySelectorAll('.customer-row');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    let visibleRows = 0;

                    customerRows.forEach((row, index) => {
                        const rowText = row.textContent.toLowerCase();
                        const isVisible = rowText.includes(searchTerm);
                        row.style.display = isVisible ? '' : 'none';

                        if (isVisible) {
                            visibleRows++;
                            row.style.animationDelay = (index * 50) + 'ms';
                        }
                    });

                    // Show/hide no results message
                    if (visibleRows === 0 && searchTerm !== '') {
                        if (!document.getElementById('noResults')) {
                            const noResultsDiv = document.createElement('div');
                            noResultsDiv.id = 'noResults';
                            noResultsDiv.className = 'text-center py-4';
                            noResultsDiv.innerHTML = `
                                <div class="empty-state">
                                    <i class="fas fa-search fa-3x text-muted opacity-25 mb-3"></i>
                                    <h5 class="text-muted">No customers found</h5>
                                    <p class="text-muted">Try adjusting your search terms.</p>
                                </div>
                            `;
                            document.getElementById('customerTableBody').appendChild(noResultsDiv);
                        }
                    } else {
                        const noResultsEl = document.getElementById('noResults');
                        if (noResultsEl) {
                            noResultsEl.remove();
                        }
                    }
                });
            }

            // Table sorting functionality
            const sortableHeaders = document.querySelectorAll('.sortable');
            let currentSort = {
                column: null,
                direction: 'asc'
            };

            sortableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const sortColumn = this.getAttribute('data-sort');
                    const tbody = document.getElementById('customerTableBody');
                    const rows = Array.from(tbody.querySelectorAll('.customer-row'));

                    // Update sort direction
                    if (currentSort.column === sortColumn) {
                        currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                    } else {
                        currentSort.direction = 'asc';
                    }
                    currentSort.column = sortColumn;

                    // Update sort icons
                    sortableHeaders.forEach(h => {
                        const icon = h.querySelector('i');
                        icon.className = 'fas fa-sort ms-1 text-muted';
                    });

                    const activeIcon = this.querySelector('i');
                    activeIcon.className =
                        `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'} ms-1 text-primary`;

                    // Sort rows
                    rows.sort((a, b) => {
                        let aValue, bValue;

                        switch (sortColumn) {
                            case 'id':
                                aValue = parseInt(a.getAttribute('data-customer-id'));
                                bValue = parseInt(b.getAttribute('data-customer-id'));
                                break;
                            case 'name':
                                aValue = a.querySelector('.customer-name').textContent
                                    .trim();
                                bValue = b.querySelector('.customer-name').textContent
                                    .trim();
                                break;
                            case 'email':
                                aValue = a.querySelector('.email-text').textContent.trim();
                                bValue = b.querySelector('.email-text').textContent.trim();
                                break;
                            case 'date':
                                aValue = new Date(a.querySelector('.registration-date')
                                    .textContent);
                                bValue = new Date(b.querySelector('.registration-date')
                                    .textContent);
                                break;
                            default:
                                return 0;
                        }

                        if (aValue < bValue) return currentSort.direction === 'asc' ? -1 :
                            1;
                        if (aValue > bValue) return currentSort.direction === 'asc' ? 1 : -
                            1;
                        return 0;
                    });

                    // Reorder DOM elements with animation
                    rows.forEach((row, index) => {
                        row.style.animationDelay = (index * 30) + 'ms';
                        tbody.appendChild(row);
                    });
                });
            });

            // Enhanced modal interactions
            const customerModals = document.querySelectorAll('[id^="viewCustomerModal-"]');
            customerModals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const modalContent = this.querySelector('.modal-content');
                    modalContent.style.animation = 'modalSlideIn 0.3s ease-out';
                });
            });

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // FIXED: Handle view buttons with proper event stopping
            const viewButtons = document.querySelectorAll('.view-customer-btn');
            viewButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Stop event bubbling to prevent row click handler
                    e.stopPropagation();
                    // The modal will be handled by Bootstrap's data-bs-toggle
                });
            });

            // FIXED: Enhanced table row click interaction (excluding button clicks)
            customerRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't trigger on button clicks or their children
                    if (e.target.closest('.btn') ||
                        e.target.closest('.action-buttons') ||
                        e.target.classList.contains('view-customer-btn')) {
                        return;
                    }

                    const customerId = this.getAttribute('data-customer-id');
                    const modal = document.getElementById(`viewCustomerModal-${customerId}`);

                    if (modal) {
                        // Check if any modal is currently open
                        const openModals = document.querySelectorAll('.modal.show');
                        if (openModals.length > 0) {
                            return; // Don't open if another modal is open
                        }

                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    }
                });

                // Add cursor pointer to indicate clickability
                row.style.cursor = 'pointer';
            });

            // Keyboard navigation support
            document.addEventListener('keydown', function(e) {
                // ESC to close modals
                if (e.key === 'Escape') {
                    const openModals = document.querySelectorAll('.modal.show');
                    openModals.forEach(modal => {
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) bsModal.hide();
                    });
                }

                // Ctrl+F to focus search
                if (e.ctrlKey && e.key === 'f') {
                    e.preventDefault();
                    const searchInput = document.getElementById('customerSearch');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });

            // Loading states for better UX
            function showLoading(element) {
                element.style.opacity = '0.6';
                element.style.pointerEvents = 'none';
            }

            function hideLoading(element) {
                element.style.opacity = '1';
                element.style.pointerEvents = 'auto';
            }

            // Add success/error toast notifications
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer') || createToastContainer();
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0`;
                toast.setAttribute('role', 'alert');
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;

                toastContainer.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast, {
                    delay: 3000
                });
                bsToast.show();

                toast.addEventListener('hidden.bs.toast', () => {
                    toast.remove();
                });
            }

            function createToastContainer() {
                const container = document.createElement('div');
                container.id = 'toastContainer';
                container.className = 'toast-container position-fixed top-0 end-0 p-3';
                container.style.zIndex = '1080';
                document.body.appendChild(container);
                return container;
            }

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe customer rows for scroll animations
            customerRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition =
                    `opacity 0.5s ease ${index * 0.05}s, transform 0.5s ease ${index * 0.05}s`;
                observer.observe(row);
            });

            // Add resize handler for responsive behavior
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    const table = document.querySelector('.modern-table');
                    if (table && window.innerWidth < 768) {
                        table.classList.add('table-sm');
                    } else {
                        table.classList.remove('table-sm');
                    }
                }, 150);
            });

            console.log('✅ Customer Management UI initialized successfully - Modal double opening issue fixed!');
        });
    </script>
@endpush
