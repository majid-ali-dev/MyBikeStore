@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="col py-3">
                <!-- Dashboard Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Build Your Custom Bike</h1>
                    <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Overlay for mobile sidebar -->
                <div class="sidebar-overlay"></div>

                <div class="container">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>Build Your Custom Bike</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach ($categories as $category)
                                        <div class="category-section mb-4">
                                            <h5 class="category-title bg-secondary text-white p-2"
                                                data-category-id="{{ $category->id }}">
                                                {{ $category->name }}
                                            </h5>

                                            <div class="row">
                                                @foreach ($category->parts as $part)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card part-card" data-part-id="{{ $part->id }}"
                                                            data-price="{{ $part->price }}">
                                                            @if ($part->image)
                                                                <img src="{{ $part->image_url }}" class="card-img-top"
                                                                    alt="{{ $part->name }}">
                                                            @else
                                                                <div class="no-image-placeholder bg-light d-flex align-items-center justify-content-center"
                                                                    style="height: 150px;">
                                                                    <i class="fas fa-image fa-3x text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div class="card-body">
                                                                <h6 class="card-title">{{ $part->name }}</h6>
                                                                <p class="card-text text-muted small">
                                                                    {{ Str::limit($part->description, 100) }}</p>
                                                                <p class="text-primary font-weight-bold">
                                                                    ${{ number_format($part->price, 2) }}</p>
                                                                <button class="btn btn-sm btn-outline-primary add-part-btn"
                                                                    data-part-id="{{ $part->id }}">
                                                                    <i class="fas fa-plus"></i> Add to Bike
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-4">
                                    <div class="card sticky-top" style="top: 20px;">
                                        <div class="card-header bg-info text-white">
                                            <h5>Your Bike Configuration</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="selected-parts-container">
                                                <p class="text-muted">No parts selected yet</p>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <strong>Subtotal:</strong>
                                                <span id="subtotal">$0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <strong>Advance (40%):</strong>
                                                <span id="advance">$0.00</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <strong>Total:</strong>
                                                <span id="total">$0.00</span>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <form id="bike-order-form" action="{{ route('customer.submit-bike-order') }}"
                                                method="POST">
                                                @csrf
                                                <div id="selected-parts-inputs-container"></div>

                                                <div class="form-group mb-3">
                                                    <label for="shipping_address">Shipping Address</label>
                                                    <textarea class="form-control" name="shipping_address" required></textarea>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="notes">Special Instructions</label>
                                                    <textarea class="form-control" name="notes"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100" id="submit-order-btn"
                                                    disabled>
                                                    Submit Order Request
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
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Confirm Your Order</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please review your order before submitting:</p>
                    <div id="modal-order-summary" class="mb-3"></div>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Subtotal:</strong>
                        <span id="modal-subtotal">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Advance (40%):</strong>
                        <span id="modal-advance">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <span id="modal-total">$0.00</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="editOrderBtn">
                        <i class="fas fa-edit"></i> Edit Order
                    </button>
                    <button type="button" class="btn btn-danger" id="cancelOrderBtn">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="confirmOrderBtn">
                        <i class="fas fa-check"></i> Confirm & Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebar = document.getElementById('sidebar');
                const sidebarClose = document.getElementById('sidebarClose');
                const body = document.body;
                const overlay = document.querySelector('.sidebar-overlay');

                // Toggle sidebar
                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function() {
                        sidebar.classList.add('show');
                        body.classList.add('sidebar-open');
                    });
                }

                // Close sidebar
                if (sidebarClose) {
                    sidebarClose.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        body.classList.remove('sidebar-open');
                    });
                }

                // Close sidebar when clicking on overlay
                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        body.classList.remove('sidebar-open');
                    });
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                let selectedParts = {};
                let subtotal = 0;
                let totalCategories = $('.category-section').length;
                const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

                $(document).on('click', '.add-part-btn', function() {
                    const partId = $(this).data('part-id');
                    const partCard = $(this).closest('.part-card');
                    const partPrice = parseFloat(partCard.data('price'));
                    const partName = partCard.find('.card-title').text();
                    const categoryId = partCard.closest('.category-section').find('.category-title').data('category-id');

                    partCard.closest('.category-section').find('.add-part-btn')
                        .html('<i class="fas fa-plus"></i> Add to Bike')
                        .removeClass('btn-success')
                        .addClass('btn-outline-primary');

                    if (selectedParts[categoryId] && selectedParts[categoryId].id === partId) {
                        subtotal -= selectedParts[categoryId].price;
                        delete selectedParts[categoryId];

                        $(this).html('<i class="fas fa-plus"></i> Add to Bike')
                            .removeClass('btn-success')
                            .addClass('btn-outline-primary');
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

                        $(this).html('<i class="fas fa-check"></i> Added')
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
                        $('#selected-parts-container').empty();
                        $('#selected-parts-inputs-container').empty();

                        selectedPartsArray.forEach(part => {
                            $('#selected-parts-container').append(`
                                <div class="selected-part mb-2" data-part-id="${part.id}" data-category-id="${part.categoryId}">
                                    <div class="d-flex justify-content-between">
                                        <span>${part.name}</span>
                                        <span>$${part.price.toFixed(2)}</span>
                                    </div>
                                </div>
                            `);

                            $('#selected-parts-inputs-container').append(`
                                <input type="hidden" name="selected_parts[]" value="${part.id}">
                            `);
                        });

                        const advance = subtotal * 0.4;
                        const total = subtotal;

                        $('#subtotal').text('$' + subtotal.toFixed(2));
                        $('#advance').text('$' + advance.toFixed(2));
                        $('#total').text('$' + total.toFixed(2));

                        if (allCategoriesSelected) {
                            $('#submit-order-btn').prop('disabled', false);
                            $('#submit-order-btn').html('Submit Order Request');
                        } else {
                            $('#submit-order-btn').prop('disabled', true);
                            const remaining = totalCategories - selectedCategoriesCount;
                            $('#submit-order-btn').html(
                                `Select ${remaining} more category${remaining > 1 ? 'ies' : 'y'}`);
                        }
                    } else {
                        $('#selected-parts-container').html('<p class="text-muted">No parts selected yet</p>');
                        $('#selected-parts-inputs-container').empty();
                        $('#submit-order-btn').prop('disabled', true);
                        $('#submit-order-btn').html('Select parts from all categories');
                        $('#subtotal').text('$0.00');
                        $('#advance').text('$0.00');
                        $('#total').text('$0.00');
                    }
                }

                $('#bike-order-form').on('submit', function(e) {
                    e.preventDefault();

                    const selectedCategoriesCount = Object.keys(selectedParts).length;

                    if (selectedCategoriesCount === 0) {
                        alert('Please select at least one part from each category');
                        return false;
                    }

                    if (selectedCategoriesCount < totalCategories) {
                        const remaining = totalCategories - selectedCategoriesCount;
                        alert(`Please select parts from ${remaining} more category${remaining > 1 ? 'ies' : 'y'}`);
                        return false;
                    }

                    if ($('textarea[name="shipping_address"]').val().trim() === '') {
                        alert('Please enter your shipping address');
                        return false;
                    }

                    // Show confirmation modal instead of submitting directly
                    showConfirmationModal();
                });

                function showConfirmationModal() {
                    // Update modal with order summary
                    $('#modal-order-summary').html($('#selected-parts-container').html());
                    $('#modal-subtotal').text($('#subtotal').text());
                    $('#modal-advance').text($('#advance').text());
                    $('#modal-total').text($('#total').text());

                    confirmationModal.show();
                }

                $('#editOrderBtn').click(function() {
                    confirmationModal.hide();
                });

                $('#cancelOrderBtn').click(function() {
                    confirmationModal.hide();
                    // Clear all selections
                    selectedParts = {};
                    subtotal = 0;
                    updateOrderSummary();
                    $('.add-part-btn').html('<i class="fas fa-plus"></i> Add to Bike')
                        .removeClass('btn-success')
                        .addClass('btn-outline-primary');
                });

                $('#confirmOrderBtn').click(function() {
                    // Submit the form programmatically
                    document.getElementById('bike-order-form').submit();
                });

                // Initialize the summary on page load
                updateOrderSummary();
            });
        </script>
    @endpush
@endsection
