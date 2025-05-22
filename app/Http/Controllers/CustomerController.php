<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Part;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display the customer dashboard.
     *
     * Shows the main customer portal with order history and account details.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
        ];

        $recentOrders = $user->orders()
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders'));
    }
    /**
     * Show the bike builder interface.
     *
     * Displays all available parts categorized for custom bike assembly.
     * Includes interactive selection interface with real-time pricing.
     *
     * @return \Illuminate\View\View
     */
    public function bikeBuilder()
    {
        $categories = PartCategory::with('parts')->get();
        return view('customer.bike-builder', compact('categories'));
    }

    /**
     * Process and submit a custom bike order.
     *
     * Handles the order submission with transaction safety:
     * 1. Validates selected parts and shipping address
     * 2. Calculates total amount and 40% advance payment
     * 3. Creates order record with customer details
     * 4. Stores all selected parts as order items
     * 5. Returns success/error response with proper redirect
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception On database transaction failure
     */
    public function submitBikeOrder(Request $request)
    {
        // Validate required order data
        $request->validate([
            'selected_parts' => 'required|array',
            'selected_parts.*' => 'exists:parts,id',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Get all selected parts with their details
            $parts = Part::whereIn('id', $request->selected_parts)->get();

            // Calculate order financials
            $totalAmount = $parts->sum('price');
            $advancePayment = $totalAmount * 0.4; // 40% advance required

            // Create the main order record
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => false,
                'advance_payment' => $advancePayment,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes
            ]);

            // Create order items for each selected part
            foreach ($parts as $part) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'part_id' => $part->id,
                    'quantity' => 1,
                    'unit_price' => $part->price,
                    'part_image_path' => $part->image // Preserve part image at time of order
                ]);
            }
            // If we reach here without exceptions, commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('customer.dashboard')
                ->with('success', 'Order submitted successfully!');

        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollBack();

            // Return with error message if transaction fails
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

        /**
     * Show all current/pending orders for the customer.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $orders = Auth::user()->orders()
            ->withCount('items')
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show completed order history for the customer.
     *
     * @return \Illuminate\View\View
     */
    public function orderHistory()
    {
        $orders = Auth::user()->orders()
            ->withCount('items')
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('customer.orders.history', compact('orders'));
    }
}
