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
                        <h2>Create New Category</h2>
                        <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <a class="btn btn-dark" href="{{ route('admin.dashboard') }}">Back</a> &nbsp;
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
