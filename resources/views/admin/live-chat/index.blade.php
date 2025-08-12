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

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white d-flex justify-content-between">
                                    <h3 class="mb-0">
                                        <i class="fas fa-headset me-2"></i>
                                        Customer Support Chat
                                    </h3>
                                    <span class="badge bg-warning">Beta</span>
                                </div>

                                <div class="card-body text-center py-5">
                                    <div class="empty-chat-state">
                                        <i class="fas fa-comments fa-4x text-primary mb-4"></i>
                                        <h3>Live Chat Dashboard</h3>
                                        <p class="text-muted">
                                            This section will show all active customer conversations.
                                            <br>
                                            <strong>Expected launch:</strong> Next System Update
                                        </p>
                                        <div class="mt-4">
                                            <button class="btn btn-primary" disabled>
                                                <i class="fas fa-plus me-2"></i>
                                                Start New Chat
                                            </button>
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
@endsection
