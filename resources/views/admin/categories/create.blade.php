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
                    <h2>Create New Categorie</h2>
                    <a href="{{ route('admin.bikes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Bike
                    </a>
                </div>

                <!-- Category Form -->
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.categories.store') }}">
                            @csrf

                            <!-- Bike Dropdown -->
                            <div class="mb-3">
                                <label class="form-label">Select Bike</label>
                                <select name="bike_id" class="form-select" required>
                                    <option value="">-- Select Bike --</option>
                                    @foreach($bikes as $bike)
                                        <option value="{{ $bike->id }}">{{ $bike->brand_name }} {{ $bike->model }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category Description</label>
                                <textarea name="description" class="form-control"></textarea>
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
