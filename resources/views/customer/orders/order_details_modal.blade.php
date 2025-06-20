<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="orderModalLabel">Order Details #<span id="modalOrderId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p><strong>Date:</strong> <span id="orderDate"></span></p>
                        <p><strong>Status:</strong> <span id="orderStatus" class="badge"></span></p>
                        <p><strong>Total Amount:</strong> $<span id="orderTotal"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Payment Information</h6>
                        <p><strong>Advance Paid:</strong> $<span id="advancePaid"></span></p>
                        <p><strong>Payment Status:</strong> <span id="paymentStatus" class="badge"></span></p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Parts Ordered</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="orderPartsTable">
                                <thead>
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

                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Shipping Details</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Address:</strong> <span id="shippingAddress"></span></p>
                        <p><strong>Notes:</strong> <span id="orderNotes"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
