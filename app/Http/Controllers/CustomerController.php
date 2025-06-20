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
        $categories = PartCategory::with(['parts' => function ($query) {
        $query->where('stock', '>', 0);
        }])
        ->get()
        ->filter(function ($category) {
            return $category->parts->count() > 0; // only keep categories that have parts
        });

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
     $request->validate([
         'selected_parts' => 'required|array',
         'selected_parts.*' => 'exists:parts,id',
         'shipping_address' => 'required|string',
         'notes' => 'nullable|string'
     ]);

     try {
         DB::beginTransaction();

        $parts = Part::whereIn('id', $request->selected_parts)->get();
        $totalAmount = $parts->sum('price');
        $advancePayment = $totalAmount * 0.4;

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => false, // Will be true after payment
            'advance_payment' => $advancePayment,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes
        ]);

      foreach ($parts as $part) {
      // Step 1: Check if part is in stock
      if ($part->stock <= 0) {
          throw new \Exception("Part '{$part->name}' is out of stock.");
      }

      // Step 2: Create Order Item
      OrderItem::create([
        'order_id' => $order->id,
        'part_id' => $part->id,
        'quantity' => 1,
        'unit_price' => $part->price,
        'part_image_path' => $part->image
      ]);

     // Step 3: Decrement stock by 1
     $part->decrement('stock');

        }

        DB::commit();

        // Redirect to payment page instead of dashboard
        return redirect()->route('customer.payment', $order);

     } catch (\Exception $e) {
         DB::rollBack();
         return back()->with('error', 'Error: '.$e->getMessage());
     }
    }


    /**
    * Display order details
    *
    * @param \App\Models\Order $order The order to display
    * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
    */
    public function showOrder(Order $order)
    {
    // Verify the order belongs to the authenticated user
    if ($order->user_id != auth()->id()) {
        abort(403, 'Unauthorized access to this order');
    }

    // Eager load items with their parts
    $order->load(['items.part']);

    // Return different views based on order status
    if ($order->status == 'completed') {
        return view('customer.orders.showorderhistory', compact('order'));
    }

    return view('customer.orders.show', compact('order'));
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
