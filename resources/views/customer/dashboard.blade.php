@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Customer Dashboard</h1>
                        <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>

                    </div>

                    <!-- Welcome Card -->
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            <img src="https://via.placeholder.com/150" alt="Profile" class="rounded-circle mb-3"
                                width="100">
                            <h3>Welcome back, {{ Auth::user()->name }}!</h3>
                            <p class="text-muted">Ready to build your dream bike?</p>
                        </div>
                    </div>

                    <!-- Other content... -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
@endpush
