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
            <!-- Mobile Toggle Button -->
            <button class="btn btn-dark d-md-none mb-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Welcome Card -->
            <div class="card shadow mb-4">
                <div class="card-body text-center py-4">
                    <h3>Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted">Ready to build your dream bike?</p>
                    <a href="{{ route('customer.bike-builder') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-tools me-2"></i>Start Building
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border-start border-primary border-4 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted">Total Orders</h6>
                                    <h2 class="mb-0">{{ $stats['total_orders'] }}</h2>
                                </div>
                                <div class="icon icon-shape bg-light-primary text-primary rounded-circle">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-start border-warning border-4 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted">Pending Orders</h6>
                                    <h2 class="mb-0">{{ $stats['pending_orders'] }}</h2>
                                </div>
                                <div class="icon icon-shape bg-light-warning text-warning rounded-circle">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-start border-success border-4 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted">Completed Orders</h6>
                                    <h2 class="mb-0">{{ $stats['completed_orders'] }}</h2>
                                </div>
                                <div class="icon icon-shape bg-light-success text-success rounded-circle">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="card shadow mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    @if ($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>{{ $order->items_count }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5>No Orders Yet</h5>
                            <p class="text-muted">Start by building your custom bike</p>
                            <a href="{{ route('customer.bike-builder') }}" class="btn btn-primary">
                                <i class="fas fa-tools me-2"></i>Build Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
