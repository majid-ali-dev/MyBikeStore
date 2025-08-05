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
                    <h2>Part Categories</h2>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Category
                    </a>
                </div>

                <!-- Categories Table -->
                <div class="card shadow">
                    <div class="card-body">
                        @if ($categories->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No categories found. Please create your first
                                category.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Parts Count</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                @if (isset($editingCategory) && $editingCategory->id == $category->id)
                                                    <form method="POST"
                                                        action="{{ route('admin.categories.update', $category) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <td>
                                                            <input type="text" name="name"
                                                                value="{{ $category->name }}"
                                                                class="form-control form-control-sm" required>
                                                        </td>
                                                        <td>{{ $category->parts_count }}</td>
                                                        <td>
                                                            <textarea name="description" class="form-control form-control-sm">{{ $category->description }}</textarea>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-sm btn-success me-1">
                                                                <i class="fas fa-check"></i> Save
                                                            </button>
                                                            <a href="{{ route('admin.categories.list') }}"
                                                                class="btn btn-sm btn-secondary">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </a>
                                                        </td>
                                                    </form>
                                                @else
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->parts_count }}</td>
                                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{ route('admin.categories.parts', $category) }}"
                                                                class="btn btn-sm btn-primary me-1" title="Manage Parts">
                                                                <i class="fas fa-puzzle-piece"></i>
                                                            </a>
                                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                                class="btn btn-sm btn-warning me-1" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.categories.destroy', $category) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    title="Delete"
                                                                    onclick="return confirm('Are you sure?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                                </a>
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
