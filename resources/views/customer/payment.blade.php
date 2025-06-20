@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Complete Your Payment</h4>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5>Order Summary</h5>
                            <p>Order #{{ $order->id }}</p>
                            <p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
                            <p>Advance Payment (40%): <strong>${{ number_format($order->advance_payment, 2) }}</strong></p>
                        </div>

                        <form id="payment-form" action="{{ route('customer.payment.process', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                Pay ${{ number_format($order->advance_payment, 2) }} via Stripe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Stripe with your publishable key
        const stripe = Stripe('{{ config('services.stripe.key') }}');
    </script>
@endsection
