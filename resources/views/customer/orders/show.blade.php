@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="main-content">

                <!-- Page Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Order Details #{{ $order->id }}</h1>
                    <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                    </a>
                </div>

                <!-- Order Summary Card -->
                <div class="card shadow">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">Order Summary</h2>
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <!-- Order Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary">Order Information</h6>
                                <div class="card border-0 shadow-none mb-2">
                                    <div class="card-body p-2">
                                        <p class="mb-2"><strong>Order Date:</strong>
                                            {{ $order->created_at->format('d M Y') }}</p>
                                        <p class="mb-2"><strong>Total Amount:</strong>
                                            ${{ number_format($order->total_amount, 2) }}</p>
                                        <p class="mb-2"><strong>Paid Total Amount:</strong>
                                            ${{ number_format($order->total_amount, 2) }}</p>
                                        @if ($order->expected_completion_date)
                                            @php
                                                $daysRemaining = now()->diffInDays(
                                                    \Carbon\Carbon::parse($order->expected_completion_date),
                                                    false,
                                                );
                                                $textClass = 'text-success';
                                                if ($daysRemaining < 0) {
                                                    $textClass = 'text-danger';
                                                } elseif ($daysRemaining <= 3) {
                                                    $textClass = 'text-warning';
                                                } elseif ($daysRemaining <= 7) {
                                                    $textClass = 'text-info';
                                                }
                                            @endphp
                                            <p class="mb-0"><strong>Estimated Completion Date:</strong>
                                                <span class="{{ $textClass }} fw-bold">
                                                    {{ \Carbon\Carbon::parse($order->expected_completion_date)->format('d M Y') }}
                                                </span>
                                            </p>
                                        @else
                                            <p class="mb-0"><strong>Estimated Completion Date:</strong>
                                                <span class="text-muted">To be confirmed</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary">Shipping Information</h6>
                                <div class="card border-0 shadow-none mb-2">
                                    <div class="card-body p-2">
                                        <p class="mb-2"><strong>Address:</strong>
                                            {{ $order->shipping_address ?? 'Not provided' }}</p>
                                        <p class="mb-2"><strong>Notes:</strong> {{ $order->notes ?? 'None' }}</p>

                                        @php
                                            // Get unique brand names from all parts in the order
                                            $brands = $order->items
                                                ->map(function ($item) {
                                                    return $item->part->category->bike->brand_name ?? null;
                                                })
                                                ->filter()
                                                ->unique()
                                                ->implode(', ');

                                            // Get colors from multiple sources
                                            $colors = collect();

                                            // Add order-level color if exists
                                            if (!empty($order->color)) {
                                                $colors->push($order->color);
                                            }

                                            // Add item-level colors if they exist
                                            $itemColors = $order->items
                                                ->map(function ($item) {
                                                    return $item->color ?? null;
                                                })
                                                ->filter()
                                                ->unique();

                                            $colors = $colors->merge($itemColors)->unique()->implode(', ');
                                        @endphp

                                        <p class="mb-2"><strong>Brand:</strong> {{ $brands ?: 'Not specified' }}</p>
                                        <p class="mb-0"><strong>Color:</strong> {{ $colors ?: 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Order Items -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 text-primary">Order Items</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Part</th>
                                                <th>Price</th>
                                                <th>Image</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->part->name }}</td>
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
