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

                <!-- Alternative: More Compact Version -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div>
                        <h2 class="mb-0">
                            <i class="fas fa-motorcycle me-2 text-primary"></i>
                            Parts List —
                            <span class="text-primary fw-bold">{{ $category->bike->brand_name }}</span>
                            <small class="text-muted">/ Category:</small>
                            <span class="text-dark fw-semibold">{{ $category->name }}</span>
                        </h2>
                        <p class="text-muted small mb-0 mt-1">
                            <i class="fas fa-info-circle me-1"></i>
                            Manage and organize parts for this specific category
                        </p>
                    </div>
                </div>

                <!-- Parts Table -->
                <div class="card shadow">
                    <div class="card-body">
                        @if ($parts->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>No parts found for this category.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($parts as $part)
                                            <tr>
                                                <td>{{ $part->id }}</td>
                                                <td>{{ $part->name }}</td>
                                                <td>
                                                    @if ($part->image)
                                                        <img src="{{ asset('storage/' . $part->image) }}"
                                                            alt="{{ $part->name }}" class="img-thumbnail"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 80px; height: 80px;">
                                                            <i class="fas fa-image text-muted" style="font-size: 24px;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>${{ number_format($part->price, 2) }}</td>
                                                <td>{{ $part->stock }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <!-- View Button -->
                                                        <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal"
                                                            data-bs-target="#viewPartModal-{{ $part->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <!-- Edit Button -->
                                                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                                            data-bs-target="#editPartModal-{{ $part->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Delete Button -->
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deletePartModal-{{ $part->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.categories.list') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Category List
                                </a>
                                {{ $parts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modals -->
    @foreach ($parts as $part)
        <div class="modal fade" id="viewPartModal-{{ $part->id }}" tabindex="-1" aria-labelledby="viewPartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPartModalLabel">View Part Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            @if ($part->image)
                                <img src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->name }}"
                                    class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 200px;">
                                    <i class="fas fa-image text-muted" style="font-size: 48px;"></i>
                                </div>
                            @endif
                        </div>
                        <p><strong>ID:</strong> {{ $part->id }}</p>
                        <p><strong>Name:</strong> {{ $part->name }}</p>
                        <p><strong>Price:</strong> ${{ number_format($part->price, 2) }}</p>
                        <p><strong>Stock:</strong> {{ $part->stock }}</p>
                        <p><strong>Description:</strong> {{ $part->description ?? 'N/A' }}</p>
                        <p><strong>Specifications:</strong> {{ $part->specifications ?? 'N/A' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modals -->
        <div class="modal fade" id="editPartModal-{{ $part->id }}" tabindex="-1" aria-labelledby="editPartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editPartForm-{{ $part->id }}" method="POST"
                        action="{{ route('admin.parts.update', $part->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPartModalLabel">Edit Part</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $part->name }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    value="{{ $part->price }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" value="{{ $part->stock }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control">{{ $part->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Specifications</label>
                                <textarea name="specifications" class="form-control">{{ $part->specifications }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                                @if ($part->image)
                                    <div class="mt-2">
                                        <small>Current Image:</small>
                                        <img src="{{ asset('storage/' . $part->image) }}" class="img-thumbnail"
                                            style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modals -->
        <div class="modal fade" id="deletePartModal-{{ $part->id }}" tabindex="-1"
            aria-labelledby="deletePartModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.parts.destroy', $part->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePartModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this part?</p>
                            <p><strong>{{ $part->name }}</strong> (ID: {{ $part->id }})</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
