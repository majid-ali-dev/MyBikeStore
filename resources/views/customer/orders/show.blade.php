@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.customer-sidebar')

            <div class="col py-3">
                <div class="container-fluid">

                    <!-- Header with Toggle Button -->
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Order Details #{{ $order->id }}</h1>
                        <div class="d-md-none">
                            <button class="btn btn-sm btn-danger" id="sidebarToggle">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary d-none d-md-inline">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                    </div>

                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="h5 mb-0">Order Summary</h2>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Order Information</h6>
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                    <p><strong>Advance Paid (40%):</strong> ${{ number_format($order->advance_payment, 2) }}
                                    </p>

                                    @if ($order->expected_completion_date)
                                        @php
                                            $daysRemaining = now()->diffInDays(
                                                \Carbon\Carbon::parse($order->expected_completion_date),
                                                false,
                                            );
                                            $textClass = 'text-success'; // Default color

                                            if ($daysRemaining < 0) {
                                                $textClass = 'text-danger'; // Overdue (red)
                                            } elseif ($daysRemaining <= 3) {
                                                $textClass = 'text-warning'; // Urgent (yellow/orange)
                                            } elseif ($daysRemaining <= 7) {
                                                $textClass = 'text-info'; // Approaching (blue)
                                            }
                                        @endphp

                                        <p><strong>Estimated Completion Date: </strong>
                                            <span class="text-primary fw-bold">
                                                {{ \Carbon\Carbon::parse($order->expected_completion_date)->format('d M Y') }}
                                            </span>
                                        </p>
                                    @else
                                        <p><strong>Estimated Completion Date:</strong>
                                            <span class="text-muted">To be confirmed</span>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6>Shipping Information</h6>
                                    <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                                    <p><strong>Notes:</strong> {{ $order->notes ?? 'None' }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Order Items</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
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
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebar = document.getElementById('sidebar');
                const sidebarClose = document.getElementById('sidebarClose');

                if (sidebarToggle && sidebar) {
                    sidebarToggle.addEventListener('click', function() {
                        sidebar.classList.remove('d-none');
                        sidebar.classList.add('d-block', 'show');
                    });
                }

                if (sidebarClose && sidebar) {
                    sidebarClose.addEventListener('click', function() {
                        sidebar.classList.remove('show', 'd-block');
                        sidebar.classList.add('d-none');
                    });
                }
            });
        </script>
    @endpush
@endsection
