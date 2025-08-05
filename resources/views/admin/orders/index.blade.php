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

                <!-- Page Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Manage Orders</h1>
                </div>

                <!-- Status Filter Buttons -->
                <div class="mb-4">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                            class="btn {{ $status == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                            <i class="fas fa-clock me-1"></i>Pending
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                            class="btn {{ $status == 'processing' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-cog me-1"></i>Processing
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
                            class="btn {{ $status == 'completed' ? 'btn-success' : 'btn-outline-success' }}">
                            <i class="fas fa-check-circle me-1"></i>Completed
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}"
                            class="btn {{ $status == 'delivered' ? 'btn-info' : 'btn-outline-info' }}">
                            <i class="fas fa-truck me-1"></i>Delivered
                        </a>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card shadow">
                    <div class="card-body">
                        @if ($orders->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No {{ $status }} orders found.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th>Delivery Deadline</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill bg-{{ $order->status == 'completed'
                                                            ? 'success'
                                                            : ($order->status == 'pending'
                                                                ? 'warning'
                                                                : ($order->status == 'processing'
                                                                    ? 'primary'
                                                                    : 'info')) }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                                                        {{ $order->payment_status ? 'Paid' : 'Pending' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($order->expected_completion_date)
                                                        <span
                                                            class="text-{{ \Carbon\Carbon::parse($order->expected_completion_date)->isPast() ? 'danger' : 'success' }}">
                                                            {{ \Carbon\Carbon::parse($order->expected_completion_date)->format('M d, Y') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                                </a>
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endpush
