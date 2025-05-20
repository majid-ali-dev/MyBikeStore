@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.customer-sidebar')

            <div class="col py-3">
                <div class="container">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>Build Your Custom Bike</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Parts Selection -->
                                <div class="col-md-8">
                                    @foreach ($categories as $category)
                                        <div class="category-section mb-4">
                                            <h5 class="category-title bg-secondary text-white p-2">
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

                                <!-- Order Summary -->
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
                                                <div id="selected-parts-inputs-container">
                                                    <!-- Dynamic inputs will be added here -->
                                                </div>

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

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                let selectedParts = [];
                let subtotal = 0;

                // Add part to bike
                $(document).on('click', '.add-part-btn', function() {
                    const partId = $(this).data('part-id');
                    const partCard = $(this).closest('.part-card');
                    const partPrice = parseFloat(partCard.data('price'));
                    const partName = partCard.find('.card-title').text();

                    if (!selectedParts.includes(partId)) {
                        selectedParts.push(partId);
                        subtotal += partPrice;
                        updateOrderSummary();

                        // Update button appearance
                        $(this).html('<i class="fas fa-check"></i> Added')
                            .removeClass('btn-outline-primary')
                            .addClass('btn-success');

                        // Add part to summary
                        $('#selected-parts-container').append(`
                    <div class="selected-part mb-2" data-part-id="${partId}">
                        <div class="d-flex justify-content-between">
                            <span>${partName}</span>
                            <span>$${partPrice.toFixed(2)}</span>
                        </div>
                    </div>
                `);

                        // Add hidden input for this part
                        $('#selected-parts-inputs-container').append(`
                    <input type="hidden" name="selected_parts[]" value="${partId}">
                `);
                    }
                });

                // Update order summary
                function updateOrderSummary() {
                    if (selectedParts.length > 0) {
                        // Enable submit button
                        $('#submit-order-btn').prop('disabled', false);

                        // Calculate prices
                        const advance = subtotal * 0.4;
                        const total = subtotal;

                        // Update UI
                        $('#subtotal').text('$' + subtotal.toFixed(2));
                        $('#advance').text('$' + advance.toFixed(2));
                        $('#total').text('$' + total.toFixed(2));
                    } else {
                        $('#selected-parts-container').html('<p class="text-muted">No parts selected yet</p>');
                        $('#selected-parts-inputs-container').empty();
                        $('#submit-order-btn').prop('disabled', true);
                        $('#subtotal').text('$0.00');
                        $('#advance').text('$0.00');
                        $('#total').text('$0.00');
                    }
                }
            });
        </script>
    @endpush
@endsection
