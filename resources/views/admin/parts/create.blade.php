@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.admin-sidebar')

            <div class="main-content">
                <button class="btn btn-dark d-md-none mb-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add New Part</h1>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Category
                    </a>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.parts.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Bike Selection -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Select Bike</label>
                                    <select name="bike_id" id="bikeSelect" class="form-select" required>
                                        <option value="">-- Select Bike --</option>
                                        @foreach ($bikes as $bike)
                                            <option value="{{ $bike->id }}">{{ $bike->brand_name }} {{ $bike->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Select Category</label>
                                    <select name="category_id" id="categorySelect" class="form-select" required disabled>
                                        <option value="">-- First select a bike --</option>
                                    </select>
                                </div>
                            </div>

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
                                            <input type="number" name="stock" min="0" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Part Image</label>
                                        <div class="image-upload-container border rounded p-3 text-center">
                                            <div id="imagePreview" class="mb-2" style="display: none;">
                                                <img id="previewImage" src="#" alt="Preview"
                                                    class="img-fluid rounded" style="max-height: 200px;">
                                            </div>
                                            <input type="file" name="image" id="imageInput" class="d-none"
                                                accept="image/*">
                                            <label for="imageInput" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-upload me-2"></i>Choose Image
                                            </label>
                                            <small class="text-muted d-block mt-2">Recommended size: 500x500px (max
                                                2MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Specifications (JSON Format)</label>
                                <textarea name="specifications" class="form-control" rows="3"
                                    placeholder='{"Material": "Steel", "Weight": "2kg", "Color": "Black"}'></textarea>
                                <small class="text-muted">Enter specifications in valid JSON format</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Part
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Bike-Category dynamic dropdown
            document.getElementById('bikeSelect').addEventListener('change', function() {
                const bikeId = this.value;
                const categorySelect = document.getElementById('categorySelect');

                if (bikeId) {
                    // Fetch categories for selected bike
                    fetch(`/admin/bikes/${bikeId}/categories`)
                        .then(response => response.json())
                        .then(data => {
                            categorySelect.innerHTML = '<option value="">-- Select Category --</option>';
                            data.forEach(category => {
                                categorySelect.innerHTML +=
                                    `<option value="${category.id}">${category.name}</option>`;
                            });
                            categorySelect.disabled = false;
                        });
                } else {
                    categorySelect.innerHTML = '<option value="">-- First select a bike --</option>';
                    categorySelect.disabled = true;
                }
            });

            // Image preview functionality
            document.getElementById('imageInput').addEventListener('change', function(e) {
                const preview = document.getElementById('imagePreview');
                const previewImage = document.getElementById('previewImage');

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        </script>
    @endpush

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
