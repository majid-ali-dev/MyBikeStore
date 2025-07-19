<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    /**
     * Show payment page with order details
     *
     * Initializes Stripe and displays payment page with order summary
     *
     * @param Order $order The order to be paid
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Initialize Stripe with secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        return view('customer.payment', [
            'order' => $order,
            'stripeKey' => config('services.stripe.key') // Publishable key for client-side
        ]);
    }

    /**
     * Process payment and redirect to Stripe Checkout
     *
     * Creates Stripe Checkout session and redirects user to payment page
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request, Order $order)
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create Stripe Checkout session
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Custom Bike Order #'.$order->id,
                            'description' => 'Advance payment (40%) for custom bike order',
                        ],
                        'unit_amount' => $order->advance_payment * 100, // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('customer.payment.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('customer.payment.cancel'),
                'metadata' => [
                    'order_id' => $order->id,
                    'customer_id' => auth()->id()
                ],
                'customer_email' => auth()->user()->email, // Send receipt to customer
            ]);

            return redirect($checkout_session->url);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Payment processing error: '.$e->getMessage());
        }
    }

    /**
     * Handle successful payment
     *
     * Verifies payment with Stripe and updates order status
     * Shows success message with order details
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function success(Request $request)
    {
        if (!auth()->check())
        {
        return redirect('/login')->with('error', 'Please login to complete payment.');
        }
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Verify the session exists
            $session = Session::retrieve($request->session_id);

            // Additional verification
            if ($session->payment_status !== 'paid') {
                throw new \Exception('Payment not completed');
            }

            // More robust order lookup
            $order = Order::where('id', $session->metadata->order_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

            // Update order status
            $order->update([
                'payment_status' => true,
                'stripe_payment_id' => $session->payment_intent,
                'status' => 'pending'
            ]);

            // Prepare success message matching your layout
            $successMessage = [
                'title' => 'Payment Successful!',
                'message' => 'Your order #'.$order->id.' is now being processed.',
                'details' => [
                    'Amount Paid' => '$'.number_format($order->advance_payment, 2),
                    'Payment Method' => 'Credit Card',
                    'Transaction ID' => $session->payment_intent,
                    'Next Steps' => 'We will contact you within 24 hours'
                ]
            ];

            return redirect()->route('customer.dashboard')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            \Log::error('Payment verification failed: '.$e->getMessage());
            return redirect()->route('customer.dashboard')
                ->with('error', 'Payment verification failed. Please contact support with this reference: '.substr($request->session_id, 0, 10));
        }
    }


    /**
     * Handle cancelled payment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request)
    {
        // Prepare cancellation message matching your layout
        $warningMessage = [
            'title' => 'Payment Cancelled',
            'message' => 'Your payment was not completed.',
            'details' => [
                'Note' => 'You can try again later from your orders page'
            ]
        ];

        return redirect()->route('customer.dashboard')
            ->with('success', $warningMessage); // Using success type to match your alert style
    }
}
