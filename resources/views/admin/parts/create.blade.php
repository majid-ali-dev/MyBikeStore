@extends('layouts.app')

@section('content')
    @include('partials.admin-sidebar')

    <div class="main-content">
        <div class="container-fluid">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Part to {{ $category->name }}</h1>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.parts.store', $category) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_id" value="{{ $category->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Part Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0" name="price"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" min="0" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Part Image</label>
                                    <div class="image-upload-container border rounded p-3 text-center">
                                        <div id="imagePreview" class="mb-2" style="display: none;">
                                            <img id="previewImage" src="#" alt="Preview" class="img-fluid rounded"
                                                style="max-height: 200px;">
                                        </div>
                                        <input type="file" name="image" id="imageInput" class="d-none"
                                            accept="image/*">
                                        <label for="imageInput" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Choose Image
                                        </label>
                                        <small class="text-muted d-block mt-2">Recommended size: 500x500px (max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Specifications (JSON Format)</label>
                            <textarea name="specifications" class="form-control" rows="3"
                                placeholder='{
  "Material": "Steel",
  "Weight": "2kg",
  "Color": "Black"
}'></textarea>
                            <small class="text-muted">Enter specifications in valid JSON format</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.categories.parts', $category) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Part
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .image-upload-container {
                min-height: 200px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: #f8f9fa;
                transition: all 0.3s ease;
            }

            .image-upload-container:hover {
                background-color: #e9ecef;
            }
        </style>
    @endpush
@endsection
