@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Parts for Category: {{ $category->name }}</h2>
            <a href="{{ route('admin.parts.create', $category) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Part
            </a>
        </div>

        @if ($parts->isEmpty())
            <div class="alert alert-info">No parts found for this category.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
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
                                        <img src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->name }}"
                                            class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="no-image"
                                            style="width: 80px; height: 80px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image" style="font-size: 24px; color: #999;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ number_format($part->price, 2) }}</td>
                                <td>{{ $part->stock }}</td>
                                <td>
                                    <!-- View Button -->
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#viewPartModal-{{ $part->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>

                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editPartModal-{{ $part->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deletePartModal-{{ $part->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- View Modal -->
                            <div class="modal fade" id="viewPartModal-{{ $part->id }}" tabindex="-1"
                                aria-labelledby="viewPartModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewPartModalLabel">View Part Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                @if ($part->image)
                                                    <img src="{{ asset('storage/' . $part->image) }}"
                                                        alt="{{ $part->name }}" class="img-fluid rounded"
                                                        style="max-height: 200px;">
                                                @else
                                                    <div class="no-image"
                                                        style="width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image" style="font-size: 48px; color: #999;"></i>
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
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editPartModal-{{ $part->id }}" tabindex="-1"
                                aria-labelledby="editPartModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="editPartForm-{{ $part->id }}" method="POST"
                                            action="{{ route('admin.parts.update', $part->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPartModalLabel">Edit Part</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $part->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Price</label>
                                                    <input type="number" step="0.01" name="price" class="form-control"
                                                        value="{{ $part->price }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" name="stock" class="form-control"
                                                        value="{{ $part->stock }}" required>
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
                                                            <img src="{{ asset('storage/' . $part->image) }}"
                                                                class="img-thumbnail" style="max-height: 100px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
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
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $parts->links() }}
            </div>
        @endif

        <a href="{{ route('admin.categories.list') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Back to Category List
        </a>
    </div>

    @push('scripts')
        <script>
            // Auto-close success/error messages after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var alerts = document.querySelectorAll('.alert');
                    alerts.forEach(function(alert) {
                        var bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            });
        </script>
    @endpush

@endsection
