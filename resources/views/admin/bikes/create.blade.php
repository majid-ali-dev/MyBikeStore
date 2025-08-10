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
                    <h2>Create New Bike</h2>
                </div>

                <!-- Bike Form -->
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.bikes.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Model</label>
                                <input type="text" name="model" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
