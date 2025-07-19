@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container py-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h3">Order #{{ $order->id }} Details</h1>
                        <div>
                            <button class="btn btn-sm btn-danger d-md-none me-2" id="sidebarToggle">
                                <i class="fas fa-bars"></i>
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Orders
                            </a>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="h5 mb-0">Order Summary</h2>
                                <div>
                                    <span
                                        class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }} text-capitalize">
                                        {{ $order->status }}
                                    </span>
                                    <span class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }} ms-2">
                                        {{ $order->payment_status ? 'Paid' : 'Pending Payment' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h3 class="h6 mb-0">Customer Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <h4 class="h6 text-muted">Customer Name</h4>
                                                <p>{{ $order->user->name }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h4 class="h6 text-muted">Email</h4>
                                                <p>{{ $order->user->email }}</p>
                                            </div>
                                            <div>
                                                <h4 class="h6 text-muted">Order Date</h4>
                                                <p>{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                                            </div>
                                            @if ($order->expected_completion_date)
                                                <div>
                                                    <h4 class="h6 text-muted">Expected Completion Date</h4>
                                                    <p>{{ \Carbon\Carbon::parse($order->expected_completion_date)->format('F j, Y \a\t g:i A') }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h3 class="h6 mb-0">Order Summary</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <h4 class="h6 text-muted">Total Amount</h4>
                                                <p class="h5">${{ number_format($order->total_amount, 2) }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h4 class="h6 text-muted">Advance Paid (40%)</h4>
                                                <p>${{ number_format($order->advance_payment, 2) }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h4 class="h6 text-muted">Shipping Address</h4>
                                                <p class="text-break">{{ $order->shipping_address }}</p>
                                            </div>
                                            @if ($order->notes)
                                                <div>
                                                    <h4 class="h6 text-muted">Special Instructions</h4>
                                                    <p class="text-break">{{ $order->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Components with Tabs -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="h6 mb-0">Order Components</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Tab Navigation -->
                                    <ul class="nav nav-tabs mb-4" id="componentTabs" role="tablist">
                                        @foreach ($order->items->groupBy('part.category.name') as $category => $items)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                    id="tab-{{ Str::slug($category) }}" data-bs-toggle="tab"
                                                    data-bs-target="#content-{{ Str::slug($category) }}" type="button"
                                                    role="tab" aria-controls="content-{{ Str::slug($category) }}"
                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                    {{ $category }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content" id="componentTabContent">
                                        @foreach ($order->items->groupBy('part.category.name') as $category => $items)
                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                id="content-{{ Str::slug($category) }}" role="tabpanel"
                                                aria-labelledby="tab-{{ Str::slug($category) }}">

                                                <h4 class="h5 mb-3 text-primary">{{ $category }}</h4>
                                                <div class="row g-4">
                                                    @foreach ($items as $item)
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                                    style="height: 200px; overflow: hidden;">
                                                                    @if ($item->part_image_path)
                                                                        <img src="{{ asset('storage/' . $item->part_image_path) }}"
                                                                            alt="{{ $item->part->name }}"
                                                                            style="object-fit: contain; width: 100%; height: 100%;">
                                                                    @else
                                                                        <div class="text-center text-muted">
                                                                            <i
                                                                                class="fas fa-motorcycle fa-4x opacity-25"></i>
                                                                            <p class="mt-2 mb-0">No Image Available</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ $item->part->name }}</h5>
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center mb-2">
                                                                        <span class="text-muted">Unit Price:</span>
                                                                        <span
                                                                            class="fw-bold">${{ number_format($item->unit_price, 2) }}</span>
                                                                    </div>
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="text-muted">Quantity:</span>
                                                                        <span
                                                                            class="badge bg-primary rounded-pill">{{ $item->quantity }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                                </a>

                                @if ($order->status == 'pending')
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                                        class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="processing">

                                        <div class="form-group mb-0">
                                            <label for="expected_completion_date" class="form-label mb-0 small">
                                                Expected Completion Date:
                                            </label>
                                            <input type="date" name="expected_completion_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('expected_completion_date', $order->expected_completion_date ?? now()->addDays(30)->format('Y-m-d')) }}"
                                                required>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-2">
                                            <i class="fas fa-check-circle me-1"></i>Accept Order
                                        </button>
                                    </form>
                                @elseif ($order->status == 'processing')
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">

                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle me-1"></i>Mark as Completed
                                        </button>
                                    </form>
                                @elseif ($order->status == 'completed')
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="delivered">

                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-truck me-1"></i>Order Delivered
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarClose');
            const overlay = document.getElementById('sidebarOverlay');

            // Initialize Bootstrap tabs
            var triggerTabList = [].slice.call(document.querySelectorAll('#componentTabs button'))
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })

            // Toggle sidebar on button click
            toggleBtn?.addEventListener('click', function() {
                sidebar.classList.add('show');
                body.classList.add('sidebar-open');
            });

            // Close sidebar on close button click
            closeBtn?.addEventListener('click', function() {
                sidebar.classList.remove('show');
                body.classList.remove('sidebar-open');
            });

            // Close sidebar when clicking on overlay
            overlay?.addEventListener('click', function() {
                sidebar.classList.remove('show');
                body.classList.remove('sidebar-open');
            });
        });
    </script>
@endpush
