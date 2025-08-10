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
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h2 class="fw-bold text-dark">Part Categories</h2>
                    <a href="{{ route('admin.parts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Part
                    </a>
                </div>

                <!-- Categories Table -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        @if ($categories->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No categories found</h5>
                                <p class="text-muted">Please create your first category.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Part Brand Name</th>
                                            <th class="fw-semibold">Part Name</th>
                                            <th class="fw-semibold">Total Parts</th>
                                            <th class="fw-semibold">Description</th>
                                            <th class="text-center fw-semibold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $brandModel => $brandCategories)
                                            <tr>
                                                <td colspan="5" class="table-secondary fw-bold py-3">
                                                    {{ $brandModel }}
                                                </td>
                                            </tr>

                                            @foreach ($brandCategories as $category)
                                                @if (isset($editingCategory) && $editingCategory->id == $category->id)
                                                    <form method="POST"
                                                        action="{{ route('admin.categories.update', $category) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <tr class="table-warning">
                                                            <td></td>
                                                            <td>
                                                                <input type="text" name="name"
                                                                    value="{{ old('name', $category->name) }}"
                                                                    class="form-control form-control-sm" required>
                                                            </td>
                                                            <td>{{ $category->parts->count() }}</td>
                                                            <td>
                                                                <textarea name="description" class="form-control form-control-sm" rows="2">{{ old('description', $category->description) }}</textarea>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-success me-1">
                                                                    <i class="fas fa-check"></i> Save
                                                                </button>
                                                                <a href="{{ route('admin.categories.list') }}"
                                                                    class="btn btn-sm btn-secondary">
                                                                    <i class="fas fa-times"></i> Cancel
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @else
                                                    <tr>
                                                        <td></td>
                                                        <td class="fw-medium">{{ $category->name }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-info">{{ $category->parts->count() }}</span>
                                                        </td>
                                                        <td class="text-muted">
                                                            {{ Str::limit($category->description, 50) }}
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.categories.parts', $category) }}"
                                                                class="btn btn-sm btn-outline-primary me-1"
                                                                title="Manage Parts">
                                                                <i class="fas fa-puzzle-piece"></i>
                                                            </a>
                                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                                class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form method="POST"
                                                                action="{{ route('admin.categories.destroy', $category) }}"
                                                                class="d-inline-block"
                                                                onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
        }

        .table th {
            border-top: none;
            color: #495057;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .btn {
            border-radius: 6px;
        }

        .btn-outline-primary:hover {
            transform: none;
        }

        .btn-outline-warning:hover {
            transform: none;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@endsection
