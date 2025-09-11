@extends('layouts.app')
@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.customer-sidebar')
            <div class="main-content">

                <!-- Bike Preview Card -->
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="mb-0">🏍️ Your Custom Bike Preview</h3>
                        <p class="mb-0">Take a look at your assembled bike!</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Bike Visual Column -->
                            <div class="col-lg-8">
                                <div class="bike-preview-container bg-gradient text-center p-4 rounded mb-4">
                                    <!-- Bike Details Header -->
                                    <div class="mb-4">
                                        <h4 class="text-white mb-2">{{ $selectedBrand->brand_name }}
                                            {{ $selectedBrand->model }}</h4>
                                        <!-- Color indicator - will be hidden after order submission -->
                                        <div class="bike-color-indicator mx-auto mb-3" id="colorIndicator"
                                            style="
                                                width: 50px;
                                                height: 50px;
                                                background-color: {{ $request->color }};
                                                border-radius: 50%;
                                                border: 3px solid white;
                                                box-shadow: 0 0 15px rgba(0,0,0,0.3);
                                            ">
                                        </div>
                                        <!-- Color name badge - will be hidden after order submission -->
                                        <span class="badge bg-light text-dark px-3 py-2" id="colorBadge">
                                            Color: {{ ucfirst($request->color) }}
                                        </span>
                                    </div>
                                    <!-- Professional Bike Icon -->
                                    <div class="bike-animation-container text-center">
                                        <div class="bike-shape rotating" id="bikeShape">
                                            <i class="fas fa-motorcycle fa-9x" style="color: {{ $request->color }}"></i>
                                        </div>
                                        <!-- Loading Animation -->
                                        <div class="loading-dots mt-4">
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                            <div class="dot"></div>
                                        </div>
                                        <p class="text-white mt-3 font-weight-bold">Assembling your bike...</p>
                                    </div>
                                    <!-- Assembly Status -->
                                    <div class="assembly-status mt-4" id="assemblyStatus">
                                        <div class="progress mb-3">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                id="assemblyProgress" style="width: 0%"></div>
                                        </div>
                                        <p class="text-white mb-0" id="assemblyText">Starting assembly...</p>
                                    </div>
                                </div>
                                <!-- Selected Parts List -->
                                <div class="selected-parts-detail bg-light p-4 rounded">
                                    <h5 class="mb-3">🔧 Selected Parts</h5>
                                    <div class="row">
                                        @foreach ($selectedParts as $part)
                                            <div class="col-md-6 mb-3">
                                                <div class="part-item d-flex align-items-center">
                                                    @if ($part->image)
                                                        <img src="{{ $part->image_url }}" class="part-thumb me-3"
                                                            style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px;">
                                                    @else
                                                        <div class="part-thumb me-3 bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px; border-radius: 8px;">
                                                            <i class="fas fa-cog text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $part->name }}</strong>
                                                        <div class="text-muted small">{{ $part->category->name }}</div>
                                                        <div class="text-success small">
                                                            ${{ number_format($part->price, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Order Summary Column -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">📋 Order Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="order-details mb-4">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><strong>Brand:</strong></span>
                                                <span>{{ $selectedBrand->brand_name }} {{ $selectedBrand->model }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><strong>Color:</strong></span>
                                                <span class="text-capitalize">{{ $request->color }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><strong>Parts:</strong></span>
                                                <span>{{ $selectedParts->count() }} items</span>
                                            </div>
                                        </div>
                                        <div class="price-breakdown bg-light p-3 rounded mb-4">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <strong>${{ number_format($totalAmount, 2) }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Advance (40%):</span>
                                                <strong
                                                    class="text-warning">${{ number_format($advancePayment, 2) }}</strong>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold">Total:</span>
                                                <strong class="text-success">${{ number_format($totalAmount, 2) }}</strong>
                                            </div>
                                        </div>
                                        <div class="shipping-info bg-light p-3 rounded mb-4">
                                            <h6>📦 Shipping Address:</h6>
                                            <p class="mb-2">{{ $request->shipping_address }}</p>
                                            @if ($request->notes)
                                                <h6>📝 Special Instructions:</h6>
                                                <p class="mb-0 text-muted">{{ $request->notes }}</p>
                                            @endif
                                        </div>
                                        <!-- Action Buttons (Initially Hidden) -->
                                        <div class="action-buttons d-none" id="actionButtons">
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary btn-lg" id="confirmOrderBtn">
                                                    <i class="fas fa-check me-2"></i>Confirm Order
                                                </button>
                                                <button class="btn btn-outline-warning" id="editOrderBtn">
                                                    <i class="fas fa-edit me-2"></i>Edit Configuration
                                                </button>
                                                <button class="btn btn-outline-danger" id="cancelOrderBtn">
                                                    <i class="fas fa-times me-2"></i>Cancel Order
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Loading Message -->
                                        <div class="text-center" id="loadingMessage">
                                            <div class="spinner-border text-primary mb-3" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="text-muted">Preparing your bike preview...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hidden Forms -->
                <form id="confirmForm" action="{{ route('customer.submit-bike-order') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
                <!-- Updated Edit Form - now includes selected part IDs to maintain selection -->
                <form id="editForm" action="{{ route('customer.bike-builder') }}" method="GET" style="display: none;">
                    <input type="hidden" name="brand_id" value="{{ $selectedBrand->id }}">
                    <input type="hidden" name="color" value="{{ $request->color }}">
                    <input type="hidden" name="shipping_address" value="{{ $request->shipping_address }}">
                    @if ($request->notes)
                        <input type="hidden" name="notes" value="{{ $request->notes }}">
                    @endif
                    @foreach ($selectedParts as $part)
                        <input type="hidden" name="selected_parts[]" value="{{ $part->id }}">
                    @endforeach
                </form>
            </div>
        </div>
    </div>
    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .bike-shape {
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotateY(0deg);
            }

            to {
                transform: rotateY(360deg);
            }
        }

        .loading-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .dot {
            width: 12px;
            height: 12px;
            background-color: white;
            border-radius: 50%;
            animation: bounce 1.4s ease-in-out infinite both;
        }

        .dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        .part-thumb {
            transition: transform 0.2s;
        }

        .part-item:hover .part-thumb {
            transform: scale(1.1);
        }

        .assembly-status {
            width: 100%;
            max-width: 400px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let progress = 0;
            const assemblySteps = [
                "Attaching wheels...",
                "Installing frame components...",
                "Setting up brakes...",
                "Adjusting gears...",
                "Final assembly...",
                "Quality check...",
                "Your bike is ready!"
            ];
            let stepIndex = 0;
            // Start assembly animation
            const progressInterval = setInterval(() => {
                progress += Math.random() * 15 + 5; // Random progress between 5-20%
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(progressInterval);
                    showActionButtons();
                }
                // Update progress bar
                document.getElementById('assemblyProgress').style.width = progress + '%';
                // Update assembly text
                if (stepIndex < assemblySteps.length - 1 && progress > (stepIndex + 1) * 14) {
                    stepIndex++;
                }
                document.getElementById('assemblyText').textContent = assemblySteps[stepIndex];
            }, 800); // Update every 800ms
            function showActionButtons() {
                // Hide loading message
                document.getElementById('loadingMessage').classList.add('d-none');
                // Show action buttons with animation
                const actionButtons = document.getElementById('actionButtons');
                actionButtons.classList.remove('d-none');
                actionButtons.style.animation = 'fadeIn 0.5s ease-in';
                // Stop bike rotation
                document.getElementById('bikeShape').style.animation = 'none';
                // Change progress bar color to success
                document.getElementById('assemblyProgress').classList.remove('bg-warning');
                document.getElementById('assemblyProgress').classList.add('bg-success');
            }
            // Button event handlers
            document.getElementById('confirmOrderBtn').addEventListener('click', function() {
                // Hide the color indicator and color badge before submitting
                document.getElementById('colorIndicator').style.display = 'none';
                document.getElementById('colorBadge').style.display = 'none';

                document.getElementById('confirmForm').submit();
            });
            document.getElementById('editOrderBtn').addEventListener('click', function() {
                document.getElementById('editForm').submit();
            });
            document.getElementById('cancelOrderBtn').addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel this order?')) {
                    // Updated: Go to bike builder with brand already selected (parts selection page)
                    // instead of starting from brand selection
                    window.location.href =
                        '{{ route('customer.bike-builder') }}?brand_id={{ $selectedBrand->id }}';
                }
            });
        });
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
