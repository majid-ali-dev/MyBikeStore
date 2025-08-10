@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <!-- Mobile Toggle Button -->
                <button class="btn btn-dark d-md-none mb-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand Selection Info  -->
                <div class="alert alert-info mb-4">
                    <strong>Selected Brand:</strong> {{ $selectedBrand->brand_name }}
                    <a href="{{ route('customer.bike-builder') }}" class="float-end btn btn-sm btn-outline-primary">
                        Change Brand
                    </a>
                </div>

                <!-- Page Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Build Your Custom Bike</h1>
                </div>

                <!-- Bike Builder Card -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Build Your Dream Bike</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Parts Selection Column -->
                            <div class="col-lg-8">
                                @foreach ($categories as $category)
                                    <div class="category-section mb-5">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="mb-0 me-3">{{ $category->name }}</h5>
                                            <span class="badge bg-secondary">{{ $category->parts->count() }} options</span>
                                        </div>

                                        <div class="row g-3">
                                            @foreach ($category->parts as $part)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card h-100 part-card" data-part-id="{{ $part->id }}"
                                                        data-price="{{ $part->price }}"
                                                        data-category-id="{{ $category->id }}">
                                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                            style="height: 180px; overflow: hidden;">
                                                            @if ($part->image)
                                                                <img src="{{ $part->image_url }}" class="img-fluid"
                                                                    style="object-fit: contain; height: 100%;"
                                                                    alt="{{ $part->name }}">
                                                            @else
                                                                <div class="text-center text-muted">
                                                                    <i class="fas fa-image fa-4x opacity-25"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <h6 class="card-title">{{ $part->name }}</h6>
                                                            <p class="card-text text-muted small mb-2">
                                                                {{ Str::limit($part->description, 80) }}
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-danger fw-bold">
                                                                    ${{ number_format($part->price, 2) }}
                                                                </span>
                                                                <button class="btn btn-sm add-part-btn"
                                                                    data-part-id="{{ $part->id }}">
                                                                    <i class="fas fa-plus me-1"></i>Select
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Summary Column -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm sticky-top" style="top: 20px;">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Your Bike Configuration</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="selected-parts-container" class="mb-3">
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i>No parts selected yet
                                            </div>
                                        </div>

                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <strong id="subtotal">$0.00</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Advance (40%):</span>
                                                <strong id="advance">$0.00</strong>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold">Total:</span>
                                                <strong id="total">$0.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <form id="bike-order-form" action="{{ route('customer.submit-bike-order') }}"
                                            method="POST">
                                            @csrf
                                            <div id="selected-parts-inputs-container"></div>

                                            <div class="mb-3">
                                                <label for="shipping_address" class="form-label">Shipping Address</label>
                                                <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Special Instructions</label>
                                                <textarea class="form-control" name="notes" rows="2"></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100" id="submit-order-btn"
                                                disabled>
                                                <i class="fas fa-paper-plane me-2"></i>Submit Order Request
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Confirm Your Order</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="mb-3">Order Summary:</h6>
                            <div id="modal-order-summary" class="mb-4"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded">
                                <h6 class="mb-3">Payment Summary:</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong id="modal-subtotal">$0.00</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Advance (40%):</span>
                                    <strong id="modal-advance">$0.00</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total:</span>
                                    <strong id="modal-total">$0.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="editOrderBtn">
                        <i class="fas fa-edit me-1"></i>Edit Order
                    </button>
                    <button type="button" class="btn btn-danger" id="cancelOrderBtn">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="confirmOrderBtn">
                        <i class="fas fa-check me-1"></i>Confirm & Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedParts = {};
            let subtotal = 0;
            let totalCategories = {{ $categories->count() }};
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

            // Part selection functionality
            $(document).on('click', '.add-part-btn', function() {
                const partId = $(this).data('part-id');
                const partCard = $(this).closest('.part-card');
                const partPrice = parseFloat(partCard.data('price'));
                const partName = partCard.find('.card-title').text();
                const categoryId = partCard.data('category-id');

                // Reset all buttons in this category
                partCard.closest('.category-section').find('.add-part-btn')
                    .html('<i class="fas fa-plus me-1"></i>Select')
                    .removeClass('btn-success')
                    .addClass('btn-outline-primary');

                // Toggle selection
                if (selectedParts[categoryId] && selectedParts[categoryId].id === partId) {
                    subtotal -= selectedParts[categoryId].price;
                    delete selectedParts[categoryId];
                } else {
                    if (selectedParts[categoryId]) {
                        subtotal -= selectedParts[categoryId].price;
                    }

                    selectedParts[categoryId] = {
                        id: partId,
                        name: partName,
                        price: partPrice,
                        categoryId: categoryId
                    };

                    subtotal += partPrice;

                    $(this).html('<i class="fas fa-check me-1"></i>Selected')
                        .removeClass('btn-outline-primary')
                        .addClass('btn-success');
                }

                updateOrderSummary();
            });

            function updateOrderSummary() {
                const selectedPartsArray = Object.values(selectedParts);
                const selectedCategoriesCount = Object.keys(selectedParts).length;
                const allCategoriesSelected = selectedCategoriesCount === totalCategories;

                if (selectedPartsArray.length > 0) {
                    let partsHtml = '';
                    let inputsHtml = '';

                    selectedPartsArray.forEach(part => {
                        partsHtml += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>${part.name}</strong>
                                <div class="text-muted small">$${part.price.toFixed(2)}</div>
                            </div>
                            <button class="btn btn-sm btn-outline-danger remove-part-btn"
                                    data-part-id="${part.id}"
                                    data-category-id="${part.categoryId}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;

                        inputsHtml += `<input type="hidden" name="selected_parts[]" value="${part.id}">`;
                    });

                    $('#selected-parts-container').html(partsHtml);
                    $('#selected-parts-inputs-container').html(inputsHtml);

                    const advance = subtotal * 0.4;
                    const total = subtotal;

                    $('#subtotal').text('$' + subtotal.toFixed(2));
                    $('#advance').text('$' + advance.toFixed(2));
                    $('#total').text('$' + total.toFixed(2));

                    if (allCategoriesSelected) {
                        $('#submit-order-btn').prop('disabled', false)
                            .html('<i class="fas fa-paper-plane me-2"></i>Submit Order Request');
                    } else {
                        $('#submit-order-btn').prop('disabled', true);
                        const remaining = totalCategories - selectedCategoriesCount;
                        $('#submit-order-btn').html(
                            `<i class="fas fa-exclamation-circle me-2"></i>Select ${remaining} more category${remaining > 1 ? 'ies' : 'y'}`
                        );
                    }
                } else {
                    $('#selected-parts-container').html(`
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>No parts selected yet
                    </div>
                `);
                    $('#selected-parts-inputs-container').empty();
                    $('#submit-order-btn').prop('disabled', true)
                        .html('<i class="fas fa-exclamation-circle me-2"></i>Select parts from all categories');
                    $('#subtotal').text('$0.00');
                    $('#advance').text('$0.00');
                    $('#total').text('$0.00');
                }
            }

            // Remove part from selection
            $(document).on('click', '.remove-part-btn', function() {
                const partId = $(this).data('part-id');
                const categoryId = $(this).data('category-id');

                if (selectedParts[categoryId]) {
                    subtotal -= selectedParts[categoryId].price;
                    delete selectedParts[categoryId];

                    // Reset the add button for this part
                    $(`.part-card[data-part-id="${partId}"] .add-part-btn`)
                        .html('<i class="fas fa-plus me-1"></i>Select')
                        .removeClass('btn-success')
                        .addClass('btn-outline-primary');

                    updateOrderSummary();
                }
            });

            // Form submission handling
            $('#bike-order-form').on('submit', function(e) {
                e.preventDefault();

                const selectedCategoriesCount = Object.keys(selectedParts).length;
                const shippingAddress = $('textarea[name="shipping_address"]').val().trim();

                if (selectedCategoriesCount === 0) {
                    showAlert('Please select at least one part from each category', 'danger');
                    return false;
                }

                if (selectedCategoriesCount < totalCategories) {
                    const remaining = totalCategories - selectedCategoriesCount;
                    showAlert(
                        `Please select parts from ${remaining} more category${remaining > 1 ? 'ies' : 'y'}`,
                        'danger');
                    return false;
                }

                if (shippingAddress === '') {
                    showAlert('Please enter your shipping address', 'danger');
                    return false;
                }

                showConfirmationModal();
            });

            function showConfirmationModal() {
                // Update modal with order summary
                let summaryHtml = '';
                Object.values(selectedParts).forEach(part => {
                    summaryHtml += `
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>${part.name}</strong>
                            <div class="text-muted small">$${part.price.toFixed(2)}</div>
                        </div>
                    </div>
                `;
                });

                $('#modal-order-summary').html(summaryHtml);
                $('#modal-subtotal').text($('#subtotal').text());
                $('#modal-advance').text($('#advance').text());
                $('#modal-total').text($('#total').text());

                confirmationModal.show();
            }

            // Modal button handlers
            $('#editOrderBtn').click(function() {
                confirmationModal.hide();
            });

            $('#cancelOrderBtn').click(function() {
                confirmationModal.hide();
                // Clear all selections
                selectedParts = {};
                subtotal = 0;
                updateOrderSummary();
                $('.add-part-btn').html('<i class="fas fa-plus me-1"></i>Select')
                    .removeClass('btn-success')
                    .addClass('btn-outline-primary');
                $('#bike-order-form')[0].reset();
            });

            $('#confirmOrderBtn').click(function() {
                // Submit the form programmatically
                document.getElementById('bike-order-form').submit();
            });

            function showAlert(message, type) {
                const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

                $('#bike-order-form').prepend(alertHtml);

                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    $('.alert').alert('close');
                }, 5000);
            }
        });
    </script>
@endpush
