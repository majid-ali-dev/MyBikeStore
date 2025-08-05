<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="orderModalLabel">Order Details #<span id="modalOrderId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <!-- Order Information -->
                    <div class="col-md-6">
                        <h6 class="text-primary">Order Information</h6>
                        <div class="card border-0 shadow-none">
                            <div class="card-body p-2">
                                <p class="mb-2"><strong>Date:</strong> <span id="orderDate"></span></p>
                                <p class="mb-2"><strong>Status:</strong> <span id="orderStatus" class="badge"></span>
                                </p>
                                <p class="mb-0"><strong>Total Amount:</strong> $<span id="orderTotal"></span></p>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Information -->
                    <div class="col-md-6">
                        <h6 class="text-primary">Payment Information</h6>
                        <div class="card border-0 shadow-none">
                            <div class="card-body p-2">
                                <p class="mb-2"><strong>Advance Paid:</strong> $<span id="advancePaid"></span></p>
                                <p class="mb-0"><strong>Payment Status:</strong> <span id="paymentStatus"
                                        class="badge"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parts Ordered -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 text-primary">Parts Ordered</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="orderPartsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Part</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Parts will be inserted here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Shipping Details -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 text-primary">Shipping Details</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Address:</strong> <span id="shippingAddress"></span></p>
                        <p class="mb-0"><strong>Notes:</strong> <span id="orderNotes"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
