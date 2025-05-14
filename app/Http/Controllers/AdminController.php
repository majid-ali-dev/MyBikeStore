<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Part;
use App\Models\User;
use App\Models\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
}
