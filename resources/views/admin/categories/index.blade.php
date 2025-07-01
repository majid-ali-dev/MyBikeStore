@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container mt-3">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h2 class="mb-4">Part Categories</h2>
                        <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            Create New Category
                        </a>
                    </div>

                    @if ($categories->isEmpty())
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
                                    @foreach ($categories as $category)
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
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Sidebar toggle functionality
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('show');
            });

            document.getElementById('sidebarClose').addEventListener('click', function() {
                document.getElementById('sidebar').classList.remove('show');
            });
        </script>
    @endpush
@endsection
