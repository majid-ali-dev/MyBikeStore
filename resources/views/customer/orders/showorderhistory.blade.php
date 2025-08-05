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

                <!-- Page Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Completed Order #{{ $order->id }}</h1>
                    <a href="{{ route('customer.orders.history') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to History
                    </a>
                </div>

                <!-- Order Summary Card -->
                <div class="card shadow">
                    <div class="card-header bg-gradient-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">Order Summary</h2>
                            <span class="badge bg-light text-dark">
                                Completed on {{ \Carbon\Carbon::parse($order->expected_completion_date)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Order Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-success">Order Information</h6>
                                <div class="card border-0 shadow-none mb-2">
                                    <div class="card-body p-2">
                                        <p class="mb-2"><strong>Order Date:</strong>
                                            {{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="mb-2"><strong>Completion Date:</strong>
                                            {{ \Carbon\Carbon::parse($order->expected_completion_date)->format('M d, Y') }}
                                        </p>
                                        <p class="mb-0"><strong>Total Amount:</strong>
                                            ${{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-success">Shipping Information</h6>
                                <div class="card border-0 shadow-none mb-2">
                                    <div class="card-body p-2">
                                        <p class="mb-2"><strong>Delivered To:</strong> {{ $order->shipping_address }}</p>
                                        @if ($order->notes)
                                            <p class="mb-0"><strong>Special Instructions:</strong> {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ordered Parts -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 text-success">Ordered Parts</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Part</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->part->name }}</td>
                                                    <td>{{ $item->part->category->name }}</td>
                                                    <td>${{ number_format($item->unit_price, 2) }}</td>
                                                    <td>
                                                        <img src="{{ $item->part_image_path ? asset('storage/' . $item->part_image_path) : 'https://via.placeholder.com/50' }}"
                                                            width="50" alt="Part Image" class="img-thumbnail">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarClose = document.getElementById('sidebarClose');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            if (sidebarClose && sidebar) {
                sidebarClose.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                });
            }
        });
    </script>
@endpush
