@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.customer-sidebar')

            <div class="col py-3">
                <div class="container-fluid">

                    <!-- Header with Toggle Button -->
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Completed Order #{{ $order->id }}</h1>
                        <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <a href="{{ route('customer.orders.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to History
                        </a>
                    </div>

                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="h5 mb-0">Order Summary</h2>
                                <span class="badge bg-light text-dark">
                                    Completed on {{ $order->updated_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Order Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Order Information</h6>
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                                    <p><strong>Completion Date:</strong> {{ $order->updated_at->format('M d, Y') }}</p>
                                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Shipping Information</h6>
                                    <p><strong>Delivered To:</strong> {{ $order->shipping_address }}</p>
                                    @if ($order->notes)
                                        <p><strong>Special Instructions:</strong> {{ $order->notes }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Ordered Parts</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
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
