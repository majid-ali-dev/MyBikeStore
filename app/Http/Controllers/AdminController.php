<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Part;
use App\Models\User;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     *
     * This method fetches the total number of customers, categories, and parts,
     * and displays them on the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalCategories = PartCategory::count();
        $totalParts = Part::count();

        // Fetch only customers
        $customers = User::where('role', 'customer')->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalCategories',
            'totalParts',
            'customers'
        ));
    }

    /**
     * Display a paginated list of customers with search functionality.
     *
     * This method allows searching customers by name, email, or phone number.
     * It returns a paginated list of customers with their order counts.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function customers(Request $request)
    {
        $query = User::withCount('orders')->where('role', 'customer');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function createCategory()
    {
        return view('admin.categories.create');
    }



    public function editCategory(PartCategory $category)
    {
    return view('admin.categories.index', [
        'categories' => PartCategory::withCount('parts')->paginate(10),
        'editingCategory' => $category // Pass the category being edited
    ]);
    }

    public function updateCategory(Request $request, PartCategory $category)
    {
    $request->validate([
        'name' => 'required|string|max:255|unique:part_categories,name,'.$category->id,
        'description' => 'nullable|string'
    ]);

    try {
        $category->update($request->only('name', 'description'));
        return redirect()->route('admin.categories.list')
            ->with('success', 'Category updated successfully!');
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Failed to update category: ' . $e->getMessage());
    }
    }

    public function destroyCategory(PartCategory $category)
    {
    try {
        // Check if category has parts before deleting
        if ($category->parts()->exists()) {
            return back()->with('error', 'Cannot delete category with associated parts.');
        }

        $category->delete();
        return redirect()->route('admin.categories.list')
            ->with('success', 'Category deleted successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to delete category: ' . $e->getMessage());
    }
    }

    /**
     * Store a newly created category in storage.
     *
     * This method validates the request data and creates a new category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:part_categories,name',
            'description' => 'nullable|string'
        ]);

        try {
            PartCategory::create($request->only('name', 'description'));
            return redirect()->route('admin.dashboard')->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to add category: ' . $e->getMessage());
        }
    }

    /**
     * Display a paginated list of parts for a specific category.
     *
     * @param \App\Models\PartCategory $category
     * @return \Illuminate\View\View
     */
    public function categoryParts(PartCategory $category)
    {
        $parts = $category->parts()->with('category')->paginate(10);
        return view('admin.parts.index', compact('category', 'parts'));
    }

    /**
     * Display a paginated list of categories with their part counts.
     *
     * @return \Illuminate\View\View
     */
    public function categoriesList()
    {
        $categories = PartCategory::withCount(['parts' => function($query) {
           $query->select(DB::raw('count(*)'));
        }])->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Display the form for creating a new part within a specific category.
     *
     * @param \App\Models\PartCategory $category
     * @return \Illuminate\View\View
     */
    public function createPart(PartCategory $category)
    {
        return view('admin.parts.create', compact('category'));
    }

    /**
     * Store a newly created part in storage.
     *
     * This method validates the request data, handles image upload, and creates a new part.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePart(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:part_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('parts_images', 'public');
        }

        Part::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'specifications' => $request->specifications,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Part added successfully!');
    }

    /**
     * Update the specified part in storage.
     *
     * This method validates the request data, handles image upload, and updates the part.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Part $part
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePart(Request $request, Part $part)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $partData = $request->except('image');

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($part->image) {
                    Storage::disk('public')->delete($part->image);
                }
                $partData['image'] = $request->file('image')->store('parts', 'public');
            }

            $part->update($partData);

            return redirect()->route('admin.categories.parts', $part->category_id)
                ->with('success', 'Part updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update part: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified part from storage.
     *
     * This method deletes the part and its associated image if it exists.
     *
     * @param \App\Models\Part $part
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPart(Part $part)
    {
        try {
            // Delete associated image if exists
            if ($part->image) {
                Storage::disk('public')->delete($part->image);
            }

            $categoryId = $part->category_id;
            $part->delete();

            return redirect()->route('admin.categories.parts', $categoryId)
                ->with('success', 'Part deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete part: ' . $e->getMessage());
        }
    }


    /**
     * Display a paginated list of orders with their details.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function ordersList(Request $request)
    {
        $status = $request->get('status', 'processing'); // Default to processing

        $orders = Order::with(['user', 'items.part'])
                ->where('status', $status)
                ->paginate(10);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrder(Request $request, Order $order)
    {
        $validationRules = [
            'status' => 'required|in:pending,processing,completed,cancelled,delivered'
        ];

        // Only require date when changing from pending to processing
        if ($order->status == 'pending' && $request->status == 'processing') {
            $validationRules['expected_completion_date'] = 'required|date|after_or_equal:today';
        } else {
            $validationRules['expected_completion_date'] = 'nullable|date';
        }

        $validated = $request->validate($validationRules);

        try {
            // Store previous status for comparison
            $previousStatus = $order->status;

            $order->status = $validated['status'];

            // Only update date if it was provided
            if (isset($validated['expected_completion_date'])) {
            $order->expected_completion_date = $validated['expected_completion_date'];
            }

            $order->save();

            // Send email when order is marked as completed
            if ($previousStatus !== 'completed' && $validated['status'] === 'completed') {
                try {
                    // Load order with user relationship for email
                    $order->load(['user', 'items.part.category']);

                    // Check if user has email
                    if ($order->user && $order->user->email) {
                        Mail::to($order->user->email)->send(new OrderCompletedMail($order));

                        // Log successful email
                        Log::info('Order completion email sent successfully', [
                            'order_id' => $order->id,
                            'user_email' => $order->user->email,
                            'user_name' => $order->user->name
                        ]);

                        return redirect()->route('admin.orders.show', $order->id)
                            ->with('success', 'Order marked as completed! Email sent to customer.');
                    } else {
                        return redirect()->route('admin.orders.show', $order->id)
                            ->with('success', 'Order marked as completed! (Customer email not available)');
                    }

                } catch (\Exception $emailException) {
                    // Log email error but don't fail the order update
                    Log::error('Failed to send order completion email', [
                        'order_id' => $order->id,
                    'error' => $emailException->getMessage()
                    ]);

                    return redirect()->route('admin.orders.show', $order->id)
                        ->with('success', 'Order marked as completed! (Email notification failed)');
                }
            }

            // Regular success message for other status changes
            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order status updated successfully!');

        } catch (\Exception $e) {
            return back()
                   ->withInput()
                   ->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }


    /**
    * Display the details of a specific order.
    *
    * @param \App\Models\Order $order
    * @return \Illuminate\View\View
    */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.part.category']);

        // Check if order is delivered to show PDF button
        $showPdfButton = $order->status === 'delivered';

        return view('admin.orders.show', compact('order', 'showPdfButton'));
    }


public function downloadAllDeliveredOrders()
{
    // Get all delivered orders with all related data
    $orders = Order::with(['user', 'items.part.category'])
        ->where('status', 'delivered')
        ->orderBy('updated_at', 'desc')
        ->get();

    // Transform data for better PDF display
    $ordersData = $orders->map(function($order) {
        return [
            'id' => $order->id,
            'customer_name' => $order->user->name,
            'customer_email' => $order->user->email ?? 'N/A',
            'total_amount' => $order->total_amount,
            'payment_status' => $order->payment_status ? 'Paid' : 'Pending',
            'delivery_date' => $order->updated_at->format('M d, Y'),
            'delivery_time' => $order->updated_at->format('H:i A'),
            'items_count' => $order->items->count(),
            'shipping_address' => $order->shipping_address,
            'notes' => $order->notes ?? 'No notes',
            'items_details' => $order->items->map(function($item) {
                return $item->part->name . ' (Qty: ' . $item->quantity . ', Price: $' . number_format($item->unit_price, 2) . ')';
            })->join(', '),
            'categories' => $order->items->map(function($item) {
                return $item->part->category->name ?? 'N/A';
            })->unique()->join(', ')
        ];
    });

    // Generate PDF
    $pdf = \PDF::loadView('admin.orders.all_delivered_pdf', compact('ordersData'))
        ->setPaper('a4', 'landscape'); // Landscape for better table display

    // Download with filename
    $filename = 'all_delivered_orders_' . now()->format('Y_m_d_H_i') . '.pdf';
    return $pdf->download($filename);
}


}
