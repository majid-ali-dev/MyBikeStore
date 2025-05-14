@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2>Add New Part to {{ $category->name }}</h2>

        <form method="POST" action="{{ route('admin.parts.store', $category) }}" enctype="multipart/form-data">
            @csrf

            <!-- Hidden input for category_id to pass in the request -->
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div class="mb-3">
                <label class="form-label">Part Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price*</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock*</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Specifications</label>
                <textarea name="specifications" class="form-control" rows="3"
                    placeholder='{"Material": "Steel", "Weight": "2kg"}'></textarea>
            </div>

            <a href="{{ route('admin.categories.parts', $category) }}" class="btn btn-secondary mb-3 mt-2">Cancel</a>
            <button type="submit" class="btn btn-primary mb-3 mt-2">Save Part</button>
        </form>
    </div>
@endsection
