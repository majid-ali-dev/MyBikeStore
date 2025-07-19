@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container mt-2">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1>Manage Orders</h1>
                        <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                            class="btn {{ $status == 'pending' ? 'btn-warning' : 'btn-outline-warning' }} ms-2">
                            Pending Orders
                        </a>

                        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                            class="btn {{ $status == 'processing' ? 'btn-primary' : 'btn-outline-primary' }} ms-2">
                            Processing Orders
                        </a>

                        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
                            class="btn {{ $status == 'completed' ? 'btn-success' : 'btn-outline-success' }} ms-2">
                            Completed Orders
                        </a>

                        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}"
                            class="btn {{ $status == 'delivered' ? 'btn-info' : 'btn-outline-info' }} ms-2">
                            Delivered Orders
                        </a>
                    </div>

                    @if ($orders->isEmpty())
                        <div class="alert alert-info">
                            No {{ $status }} orders found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th><u>Delivery Deadline</u></th>
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
                                                    class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                                                    {{ $order->payment_status ? 'Paid' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($order->expected_completion_date)
                                                    <span
                                                        class="text-success">{{ \Carbon\Carbon::parse($order->expected_completion_date)->format('M d, Y') }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $orders->links() }}
                        </div>
                    @endif
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark mt-2 mb-2">Back</a>
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
