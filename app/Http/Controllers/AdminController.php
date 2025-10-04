<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Part;
use App\Models\User;
use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Display the admin dashboard with statistics and recent customers.
     * Shows total counts for customers, bikes, categories, and parts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalBikes = Bike::count();
        $totalCategories = PartCategory::count();
        $totalParts = Part::count();


        // Fetch only customers
        $customers = User::where('role', 'customer')->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalBikes',
            'totalCategories',
            'totalParts',
            'customers',

        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Customer Management Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Display a paginated list of customers with search functionality.
     * Allows searching customers by name, email, or phone number.
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

    /*
    |--------------------------------------------------------------------------
    | Bike Management Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Show the form for creating a new bike brand/model.
     *
     * @return \Illuminate\View\View
     */
    public function createBike()
    {
        return view('admin.bikes.create');
    }

    /**
     * Store a newly created bike in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBike(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
        ]);

        Bike::create([
            'brand_name' => $request->brand_name,
            'model' => $request->model,
        ]);

        return redirect()->route('admin.categories.create')->with('success', 'Bike created successfully.');
    }

    /**
     * Get categories for a specific bike (AJAX endpoint).
     *
     * @param \App\Models\Bike $bike
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBikeCategories(Bike $bike)
    {
        return response()->json($bike->categories);
    }

    /*
    |--------------------------------------------------------------------------
    | Category Management Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Display the form for creating a new part category.
     *
     * @return \Illuminate\View\View
     */
    public function createCategory()
    {
        $bikes = Bike::all();
        return view('admin.categories.create', compact('bikes'));
    }

    /**
     * Store a newly created category in the database.
     * Validates uniqueness within the same bike brand.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'bike_id' => 'required|exists:bikes,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('part_categories')->where(function ($query) use ($request) {
                    return $query->where('bike_id', $request->bike_id);
                }),
            ],
            'description' => 'nullable|string',
        ]);

        try {
            PartCategory::create([
                'bike_id' => $request->bike_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.parts.create')->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to add category: ' . $e->getMessage());
        }
    }

    /**
     * Display all categories grouped by bike brand and model.
     *
     * @return \Illuminate\View\View
     */
    public function categoriesList()
    {
        $categories = PartCategory::with(['bike', 'parts'])
            ->get()
            ->groupBy(function ($category) {
                $brand = $category->bike->brand_name ?? 'Unknown';
                $model = $category->bike->model ?? 'N/A';
                return "{$brand} / Model: {$model}";
            });

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for editing a specific category.
     *
     * @param \App\Models\PartCategory $category
     * @return \Illuminate\View\View
     */
    public function editCategory(PartCategory $category)
    {
        $groupedCategories = PartCategory::with(['bike', 'parts'])
            ->get()
            ->groupBy(function ($cat) {
                return $cat->bike->brand_name ?? 'Unknown';
            });

        return view('admin.categories.index', [
            'categories' => $groupedCategories,
            'editingCategory' => $category,
        ]);
    }

    /**
     * Update the specified category in the database.
     * Prevents duplicate category names within the same bike brand.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PartCategory $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(Request $request, PartCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Check if category name already exists in the same brand (bike_id), but skip current category
        $duplicate = PartCategory::where('bike_id', $category->bike_id)
            ->where('name', $request->name)
            ->where('id', '!=', $category->id)
            ->exists();

        if ($duplicate) {
            return back()->withInput()->with('error', 'This category name already exists under the same brand.');
        }

        try {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.categories.list')
                ->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }


    /**
    * Delete the specified category from the database.
    * Prevents deletion if category has associated parts.
    *
    * @param \App\Models\PartCategory $category
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroyCategory(PartCategory $category)
    {
        // Check if category has any parts
        if ($category->parts()->count() > 0) {
            return back()->with('error', 'Cannot delete category that contains parts. Please remove all parts first.');
        }

        try {
            $categoryName = $category->name;
            $category->delete();

            return redirect()->route('admin.categories.list')
            ->with('success', "Category '{$categoryName}' has been deleted successfully!");

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Parts Management Methods
    |--------------------------------------------------------------------------
    */

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
     * Display the form for creating a new part.
     * Shows all bikes with their associated categories.
     *
     * @return \Illuminate\View\View
     */
    public function createPart()
    {
        $bikes = Bike::with('categories')->get();
        return view('admin.parts.create', compact('bikes'));
    }

    /**
     * Store a newly created part in the database.
     * Validates uniqueness within the same brand and category, handles image upload.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePart(Request $request)
    {
        $request->validate([
            'bike_id' => 'required|exists:bikes,id',
            'category_id' => 'required|exists:part_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
        ]);

        // Check for duplicate part name under same brand and category
        $duplicate = Part::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->whereHas('category', function ($query) use ($request) {
                $query->where('bike_id', $request->bike_id);
            })
            ->exists();

        if ($duplicate) {
            return back()->withInput()->with('error', 'Part with the same name already exists under the selected brand and category.');
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('parts_images', 'public');
        }

        // Save part
        Part::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'specifications' => $request->specifications,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.parts.create')
            ->with('success', 'Part added successfully!');
    }

    /**
     * Update the specified part in the database.
     * Handles image replacement and validates uniqueness within category.
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
            // Check duplicate name within same category
            $existingPart = Part::where('name', $request->name)
                ->where('category_id', $part->category_id)
                ->where('id', '!=', $part->id)
                ->first();

            if ($existingPart) {
                return back()->with('error', 'Part with this name already exists in this category.')->withInput();
            }

            $partData = $request->except('image');

            if ($request->hasFile('image')) {
                if ($part->image) {
                    Storage::disk('public')->delete($part->image);
                }
                $partData['image'] = $request->file('image')->store('parts', 'public');
            }

            $part->update($partData);

            return redirect()->route('admin.categories.parts', $part->category_id)
                ->with('success', 'Part updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update part: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified part from the database.
     * Deletes associated image file if it exists.
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

    /*
    |--------------------------------------------------------------------------
    | Orders Management Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Display a paginated list of orders filtered by status.
     * Default status is 'processing' if not specified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function ordersList(Request $request)
    {
        $status = $request->get('status', 'processing');

        $orders = Order::with('brand')
            ->where('status', $status)
            ->paginate(10);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    /**
     * Display the details of a specific order.
     * Shows complete order information including customer and parts details.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.part.category', 'brand']);

        // Check if order is delivered to show PDF button
        $showPdfButton = $order->status === 'delivered';

        return view('admin.orders.show', compact('order', 'showPdfButton'));
    }

    /**
     * Update the specified order status in the database.
     * Sends email notification when order is marked as completed.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
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
     * Download all delivered orders as a PDF report.
     * Generates comprehensive report with customer and order details.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadAllDeliveredOrders()
    {
        // Get all delivered orders with all related data including brand
        $orders = Order::with(['user', 'items.part.category', 'brand'])
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
                'brand_info' => $order->brand ? $order->brand->brand_name . ($order->brand->model ? ' ('.$order->brand->model.')' : '') : 'N/A',
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
            ->setPaper('a4', 'landscape');

        // Download with filename
        $filename = 'all_delivered_orders_' . now()->format('Y_m_d_H_i') . '.pdf';
        return $pdf->download($filename);
    }


}
