<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Part;
use App\Models\PartCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Display the customer dashboard with statistics and recent orders.
     * Shows order counts by status and displays the 5 most recent orders.
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

    /*
    |--------------------------------------------------------------------------
    | Bike Builder Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Show the bike builder interface with brand selection.
     * If no brand is selected, shows brand selection page.
     * If brand is selected, shows parts categorized for custom bike assembly.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function bikeBuilder(Request $request)
    {
        // Check if brand is selected
        if (!$request->has('brand_id')) {
            $brands = Bike::all();
            return view('customer.select-brand', compact('brands'));
        }

        // Store selected brand in session
        session(['selected_brand_id' => $request->brand_id]);

        // Get categories and parts for selected brand
        $categories = PartCategory::with(['parts' => function ($query) {
                $query->where('stock', '>', 0);
            }])
            ->where('bike_id', $request->brand_id)
            ->get()
            ->filter(function ($category) {
                return $category->parts->count() > 0;
            });

        return view('customer.bike-builder', [
            'categories' => $categories,
            'selectedBrand' => Bike::find($request->brand_id)
        ]);
    }


    /**
    * Show bike preview with selected parts before final confirmation
    */
    public function bikePreview(Request $request)
    {
        $request->validate([
            'selected_parts' => 'required|array',
            'selected_parts.*' => 'exists:parts,id',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'color' => 'required|string'
        ]);

        // Get brand ID from session
        $brandId = session('selected_brand_id');
        if (!$brandId) {
            return redirect()->route('customer.bike-builder')->with('error', 'Please select a brand first.');
        }

        // Get selected brand
        $selectedBrand = Bike::find($brandId);

        // Get selected parts with their categories
        $selectedParts = Part::whereIn('id', $request->selected_parts)
            ->with('category')
            ->get();

        // Calculate totals
        $totalAmount = $selectedParts->sum('price');
        $advancePayment = $totalAmount * 0.4;

        // Store form data in session for later use
        session([
            'preview_data' => [
                'selected_parts' => $request->selected_parts,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'color' => $request->color,
                'total_amount' => $totalAmount,
                'advance_payment' => $advancePayment
            ]
        ]);

        return view('customer.bike-preview', compact(
            'selectedBrand',
            'selectedParts',
            'totalAmount',
            'advancePayment',
            'request'
        ));
    }

    /**
     * Process and submit a custom bike order with transaction safety.
     * Validates parts selection, calculates pricing, creates order and items.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
     /**
     * Process and submit a custom bike order with transaction safety.
     * Now uses data from session (from preview page)
     */
    public function submitBikeOrder(Request $request)
    {
     try {
        // Get preview data from session
        $previewData = session('preview_data');
        if (!$previewData) {
            return redirect()->route('customer.bike-builder')
                ->with('error', 'Session expired. Please configure your bike again.');
        }

        DB::beginTransaction();

        // Get the brand ID from session
        $brandId = session('selected_brand_id');
        if (!$brandId) {
            throw new \Exception("No bike brand selected. Please select a brand first.");
        }

        // Get selected parts
        $selectedParts = Part::whereIn('id', $previewData['selected_parts'])
            ->with('category')
            ->get();

        // Validate stock
        foreach ($selectedParts as $part) {
            if ($part->stock <= 0) {
                throw new \Exception("Part '{$part->name}' is out of stock.");
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'brand_id' => $brandId,
            'total_amount' => $previewData['total_amount'],
            'status' => 'pending',
            'payment_status' => false,
            'advance_payment' => $previewData['advance_payment'],
            'shipping_address' => $previewData['shipping_address'],
            'notes' => $previewData['notes'],
            'color' => $previewData['color'],
        ]);

        foreach ($selectedParts as $part) {
            OrderItem::create([
                'order_id' => $order->id,
                'part_id' => $part->id,
                'quantity' => 1,
                'unit_price' => $part->price,
                'part_image_path' => $part->image
            ]);

            $part->decrement('stock');
        }

        DB::commit();

        // Clear sessions
        // $request->session()->forget(['selected_brand_id', 'preview_data']);

        return redirect()->route('customer.payment', $order)
            ->with('success', 'Order confirmed! Proceed with payment.');

     } catch (\Exception $e) {
         DB::rollBack();
         return back()->with('error', 'Error: '.$e->getMessage());
     }
    }


    /*
    |--------------------------------------------------------------------------
    | Orders Management Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Display all current/pending orders for the authenticated customer.
     * Shows orders with status: pending, processing, or completed.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $orders = Auth::user()->orders()
            ->withCount('items')
            ->whereIn('status', ['pending', 'processing', 'completed'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display detailed information for a specific order.
     * Verifies order ownership and shows appropriate view based on status.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */

    public function showOrder(Order $order)
    {
        // Verify the order belongs to the authenticated user
        if ($order->user_id != auth()->id()) {
            abort(403, 'Unauthorized access to this order');
        }

        // Eager load items with their parts and categories with brand
        $order->load(['items.part.category.bike']);

        // Return different views based on order status
        if ($order->status == 'completed') {
            return view('customer.orders.showorderhistory', compact('order'));
        }

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Display order history showing only delivered orders.
     * Shows completed/delivered orders for the authenticated customer.
     *
     * @return \Illuminate\View\View
     */
    public function orderHistory()
    {
        $orders = Auth::user()->orders()
            ->withCount('items')
            ->where('status', 'delivered')
            ->latest()
            ->paginate(10);

        return view('customer.orders.history', compact('orders'));
    }


    /**
     * Display comprehensive information about MyBikeStore.
     * Shows company overview, services, ordering process, payment methods,
     * and frequently asked questions for new customers.
     *
     * @return \Illuminate\View\View
     */
    public function aboutMyBikeShop()
    {
        // Get some basic statistics for the about page
        $totalBikes = Bike::count();
        $totalCategories = PartCategory::count();
        $totalParts = Part::count();
        $totalCustomers = User::where('role', 'customer')->count();

        return view('customer.About_Us.about_mybikestore', compact(
            'totalBikes',
            'totalCategories',
            'totalParts',
            'totalCustomers'
        ));
    }


}
