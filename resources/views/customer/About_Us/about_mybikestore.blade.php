@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <!-- Page Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        About MyBikeStore
                    </h1>
                </div>

                <!-- Hero Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                            <div class="card-body p-5 text-center">
                                <h1 class="display-4 fw-bold mb-3">
                                    <i class="fas fa-motorcycle me-3"></i>
                                    Welcome to MyBikeStore
                                </h1>
                                <p class="lead mb-4">Your Ultimate Destination for Custom Motorcycle Building</p>
                                <p class="fs-5">Professional • Reliable • Innovative</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Section -->
                <div class="row mb-5">
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-motorcycle fa-3x"></i>
                                </div>
                                <h3 class="fw-bold text-primary">{{ $totalBikes }}+</h3>
                                <p class="text-muted mb-0">Bike Models</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-success mb-2">
                                    <i class="fas fa-list fa-3x"></i>
                                </div>
                                <h3 class="fw-bold text-success">{{ $totalCategories }}+</h3>
                                <p class="text-muted mb-0">Part Categories</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-cogs fa-3x"></i>
                                </div>
                                <h3 class="fw-bold text-warning">{{ $totalParts }}+</h3>
                                <p class="text-muted mb-0">Quality Parts</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-info mb-2">
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                                <h3 class="fw-bold text-info">{{ $totalCustomers }}+</h3>
                                <p class="text-muted mb-0">Happy Customers</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About Us Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-star me-2"></i>
                                    Who We Are
                                </h2>
                                <p class="fs-6 text-muted line-height-lg">
                                    MyBikeStore is Pakistan's premier custom motorcycle building platform, founded with a
                                    passion for creating unique, high-quality motorcycles tailored to your specific needs.
                                    We combine traditional craftsmanship with modern technology to deliver exceptional
                                    custom bikes that reflect your personality and riding style.
                                </p>
                                <p class="fs-6 text-muted line-height-lg">
                                    Our team of experienced professionals and motorcycle enthusiasts work tirelessly to
                                    ensure every custom build meets the highest standards of quality, safety, and
                                    performance. From concept to completion, we're here to make your dream bike a reality.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Our Services Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-tools me-2"></i>
                                    Our Services
                                </h2>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3 text-primary">
                                                <i class="fas fa-wrench fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Custom Bike Building</h5>
                                                <p class="text-muted mb-0">Build your dream motorcycle from scratch with our
                                                    interactive bike builder tool. Choose from premium parts and components.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3 text-success">
                                                <i class="fas fa-cogs fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Quality Parts & Components</h5>
                                                <p class="text-muted mb-0">Access to genuine, high-quality motorcycle parts
                                                    from trusted brands and suppliers worldwide.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3 text-warning">
                                                <i class="fas fa-shipping-fast fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Fast & Secure Delivery</h5>
                                                <p class="text-muted mb-0">Professional assembly and secure delivery of your
                                                    custom motorcycle to your doorstep.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3 text-info">
                                                <i class="fas fa-headset fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-2">Expert Support</h5>
                                                <p class="text-muted mb-0">24/7 customer support and expert guidance
                                                    throughout your bike building journey.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How It Works Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-route me-2"></i>
                                    How It Works - Simple 4-Step Process
                                </h2>
                                <div class="row">
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="text-center">
                                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 80px; height: 80px;">
                                                <i class="fas fa-search text-white fa-2x"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">1. Browse & Select</h5>
                                            <p class="text-muted small">Choose your bike brand and explore our extensive
                                                collection of premium parts and components.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="text-center">
                                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 80px; height: 80px;">
                                                <i class="fas fa-palette text-white fa-2x"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">2. Customize</h5>
                                            <p class="text-muted small">Use our bike builder to customize every aspect of
                                                your motorcycle according to your preferences.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="text-center">
                                            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 80px; height: 80px;">
                                                <i class="fas fa-credit-card text-white fa-2x"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">3. Pay Securely</h5>
                                            <p class="text-muted small">Make a secure payment with just 40% advance
                                                payment. Pay the remaining after completion.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="text-center">
                                            <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                style="width: 80px; height: 80px;">
                                                <i class="fas fa-motorcycle text-white fa-2x"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">4. Get Delivered</h5>
                                            <p class="text-muted small">Receive your professionally assembled custom
                                                motorcycle at your preferred address.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Process Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Payment Process
                                </h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <h5 class="fw-bold text-success mb-2">
                                                <i class="fas fa-shield-alt me-2"></i>
                                                Secure Payment Options
                                            </h5>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i
                                                        class="fas fa-check-circle text-success me-2"></i>Stripe Payment
                                                    Gateway</li>
                                                <li class="mb-2"><i
                                                        class="fas fa-check-circle text-success me-2"></i>Credit/Debit
                                                    Cards</li>
                                                <li class="mb-2"><i
                                                        class="fas fa-check-circle text-success me-2"></i>Online Banking
                                                </li>
                                                <li class="mb-2"><i
                                                        class="fas fa-check-circle text-success me-2"></i>256-bit SSL
                                                    Encryption</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <h5 class="fw-bold text-info mb-2">
                                                <i class="fas fa-calculator me-2"></i>
                                                Payment Structure
                                            </h5>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i
                                                        class="fas fa-arrow-right text-info me-2"></i><strong>40% Advance
                                                        Payment</strong> - After order confirmation</li>
                                                <li class="mb-2"><i
                                                        class="fas fa-arrow-right text-info me-2"></i><strong>60% Final
                                                        Payment</strong> - Upon completion & before delivery</li>
                                                <li class="mb-2"><i
                                                        class="fas fa-arrow-right text-info me-2"></i><strong>No Hidden
                                                        Charges</strong> - Transparent pricing</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Management Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    Order Management & Tracking
                                </h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="fw-bold mb-3">Order Status Tracking</h5>
                                        <div class="mb-3">
                                            <span class="badge bg-warning text-dark me-2">Pending</span>
                                            <small class="text-muted">Order received, waiting for processing</small>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-info me-2">Processing</span>
                                            <small class="text-muted">Parts sourcing and assembly in progress</small>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-success me-2">Completed</span>
                                            <small class="text-muted">Assembly completed, ready for delivery</small>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-primary me-2">Delivered</span>
                                            <small class="text-muted">Successfully delivered to your address</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="fw-bold mb-3">What You Get</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Real-time
                                                order updates via email</li>
                                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Expected
                                                completion date notification</li>
                                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Detailed
                                                order history and invoices</li>
                                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>24/7 order
                                                status tracking</li>
                                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Customer
                                                support throughout the process</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Frequently Asked Questions
                                </h2>
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item border-0 mb-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq1">
                                                How long does it take to build a custom motorcycle?
                                            </button>
                                        </h2>
                                        <div id="faq1" class="accordion-collapse collapse show"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                The build time varies depending on parts availability and customization
                                                complexity. Typically, it takes 2-4 weeks from order confirmation to
                                                completion. You'll receive an expected completion date when your order moves
                                                to processing status.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-0 mb-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq2">
                                                What if I want to cancel or modify my order?
                                            </button>
                                        </h2>
                                        <div id="faq2" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Orders can be cancelled or modified within 24 hours of placement if they
                                                haven't entered processing status. Once processing begins, modifications may
                                                not be possible. Contact our support team immediately for assistance.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-0 mb-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq3">
                                                Do you provide warranty on custom motorcycles?
                                            </button>
                                        </h2>
                                        <div id="faq3" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Yes, we provide a comprehensive warranty on workmanship and assembly.
                                                Individual parts come with manufacturer warranties. Our support team will
                                                assist you with any warranty claims or technical issues.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-0 mb-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq4">
                                                Can I track my order progress?
                                            </button>
                                        </h2>
                                        <div id="faq4" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Absolutely! You can track your order status in real-time through your
                                                customer dashboard. You'll also receive email notifications for each status
                                                update and important milestones.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body p-4 text-center">
                                <h2 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-envelope me-2"></i>
                                    Still Have Questions?
                                </h2>
                                <p class="lead mb-4">Our friendly support team is here to help you every step of the way!
                                </p>
                                <div class="row justify-content-center">
                                    <div class="col-md-4 mb-3">
                                        <div class="p-3">
                                            <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                                            <h6 class="fw-bold">Phone Support</h6>
                                            <p class="text-muted small">+92-3056789899</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-3">
                                            <i class="fas fa-envelope fa-2x text-success mb-2"></i>
                                            <h6 class="fw-bold">Email Support</h6>
                                            <p class="text-muted small">support@mybikestore.pk</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-3">
                                            <i class="fas fa-clock fa-2x text-info mb-2"></i>
                                            <h6 class="fw-bold">Available</h6>
                                            <p class="text-muted small">24/7 Online Support</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('customer.bike-builder') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-rocket me-2"></i>
                                    Start Building Your Dream Bike
                                </a>
                                <br>
                                {{-- <a href="{{ url('/customer/contact-us') }}" class="btn btn-warning mt-3">
                                    <b>
                                        <i class="fas fa-envelope me-1"></i>
                                        Contact Us
                                    </b>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .line-height-lg {
            line-height: 1.8;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #0d6efd;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
