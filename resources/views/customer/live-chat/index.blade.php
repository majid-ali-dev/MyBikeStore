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

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h3 class="mb-0">
                                        <i class="fas fa-comment-medical me-2"></i>
                                        Support Live Chat
                                    </h3>
                                </div>

                                <div class="card-body text-center py-5">
                                    <div class="chat-placeholder">
                                        <i class="fas fa-robot fa-5x text-success mb-4"></i>
                                        <h2 class="text-success">Chat Support Coming Soon!</h2>
                                        <div class="alert alert-info mt-4">
                                            <i class="fas fa-info-circle me-2"></i>
                                            For immediate assistance, please email: support@mybikestore.com
                                        </div>
                                        <div class="mt-3">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar progress-bar-striped bg-success"
                                                    style="width: 40%"></div>
                                            </div>
                                            <small class="text-muted">Development in progress (40%)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .chat-placeholder {
                        padding: 2rem;
                        border: 2px dashed #e9ecef;
                        border-radius: 0.5rem;
                        background-color: #f8f9fa;
                    }
                </style>
            </div>
        </div>
    </div>
@endsection
