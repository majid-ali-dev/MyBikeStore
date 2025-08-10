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

                <!-- Brand Selection Card -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Select Bike Brand</h4>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('customer.bike-builder') }}">
                            <div class="mb-4">
                                <label class="form-label fs-5">Choose Your Bike Brand</label>
                                <select class="form-select form-select-lg" name="brand_id" required>
                                    <option value="">-- Select Brand --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->brand_name }} {{ $brand->model ? ' - ' . $brand->model : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-arrow-right me-2"></i> Continue to Parts Selection
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar'); // Adjust selector as needed

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
@endpush
