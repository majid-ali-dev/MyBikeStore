@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h2 class="mb-4">Part Categories</h2>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create New Category
        </a>
    </div>

    @if($categories->isEmpty())
        <div class="alert alert-info">No categories found. Please create your first category.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Parts Count</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parts_count }}</td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <a href="{{ route('admin.categories.parts', $category) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-puzzle-piece"></i> Manage Parts
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">Back</a>
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
