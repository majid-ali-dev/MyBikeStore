@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Customer Management</h1>
                        <button class="btn btn-sm btn-danger d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <!-- Customer List -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Customers</h5> &nbsp; &nbsp;
                            <form method="GET" action="{{ route('admin.customers') }}" class="w-100">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search customers..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Registered On</th>
                                            <th>Orders</th>
                                            {{-- <th>Status</th> --}}
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->id }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone ?? 'N/A' }}</td>
                                                <td>{{ $customer->created_at->format('d M Y') }}</td>
                                                <td>{{ $customer->orders_count }}</td>
                                                {{-- <td>{{ $customer->status }}</td> --}}
                                                <td>
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#viewCustomerModal-{{ $customer->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- View Customer Modal -->
                                            <div class="modal fade" id="viewCustomerModal-{{ $customer->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Customer Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>ID:</strong> {{ $customer->id }}</p>
                                                                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                                                                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                                                                    <p><strong>Phone:</strong>
                                                                        {{ $customer->phone ?? 'N/A' }}</p>
                                                                    <p><strong>Registered On:</strong>
                                                                        {{ $customer->created_at->format('d M Y') }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Total Orders:</strong>
                                                                        {{ $customer->orders_count }}</p>
                                                                    <!-- Add more details as needed -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $customers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
