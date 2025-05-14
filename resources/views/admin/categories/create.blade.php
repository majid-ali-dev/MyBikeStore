@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2>Create New Category</h2>
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
@endsection
