<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatCustomerController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes for user authentication including login, register, and logout
*/

// Display login form
Route::view('login', 'login')->name('login');
// Process login credentials
Route::post('loginMatch', [UserController::class, 'login'])->name('loginMatch');

// Display registration form
Route::view('register', 'register')->name('register');
// Process user registration
Route::post('registerSave', [UserController::class, 'register'])->name('registerSave');

// Handle user logout
Route::match(['get', 'post'], 'logout', [UserController::class, 'logout'])->name('logout');

// Login with Google - redirect to Google OAuth
Route::get('/auth/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.login');
// Handle Google OAuth callback
Route::get('/auth/callback', [LoginController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Protected routes for admin users only - requires authentication and admin role
*/

Route::middleware(['auth', 'admin:admin'])->prefix('admin')->group(function () {

    // Dashboard - show admin overview and statistics
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Customers management - display all customers with search functionality
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');

    // Bikes - create new bike brands/models
    Route::get('/bikes/create', [AdminController::class, 'createBike'])->name('admin.bikes.create');
    Route::post('/bikes', [AdminController::class, 'storeBike'])->name('admin.bikes.store');

    // Get categories for specific bike (AJAX endpoint)
    Route::get('/bikes/{bike}/categories', [AdminController::class, 'getBikeCategories'])->name('admin.bikes.categories');

    // Categories - manage part categories
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories', [AdminController::class, 'categoriesList'])->name('admin.categories.list');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Parts management within categories
    Route::get('/categories/{category}/parts', [AdminController::class, 'categoryParts'])->name('admin.categories.parts');
    Route::get('/categories/{category}/parts/create', [AdminController::class, 'createPart'])->name('admin.parts.create');

    // Parts - create, store, update and delete parts
    Route::get('/parts/create', [AdminController::class, 'createPart'])->name('admin.parts.create');
    Route::post('/parts', [AdminController::class, 'storePart'])->name('admin.parts.store');
    Route::put('/parts/{part}', [AdminController::class, 'updatePart'])->name('admin.parts.update');
    Route::delete('/parts/{part}', [AdminController::class, 'destroyPart'])->name('admin.parts.destroy');

    // Orders management
    Route::get('/admin/orders', [AdminController::class, 'ordersList'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::put('/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');

    // Download all delivered orders as PDF
    Route::get('/orders/download-all-delivered', [AdminController::class, 'downloadAllDeliveredOrders'])->name('admin.orders.download_all_delivered');

    // Live Chat - Add after order management routes
    Route::get('/live-chat', [ChatAdminController::class, 'liveChat'])->name('admin.live-chat');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
| Protected routes for customer users only - requires authentication and customer role
*/

Route::middleware(['auth', 'customer:customer'])->prefix('customer')->group(function () {

    // Dashboard - show customer overview and recent orders
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

    // Bike builder - custom bike configuration interface
    Route::get('/bike-builder', [CustomerController::class, 'bikeBuilder'])->name('customer.bike-builder');

    // Bike preview page before confirmation
    Route::post('/bike-preview', [CustomerController::class, 'bikePreview'])->name('customer.bike-preview');

    // Submit custom bike order
    Route::post('/submit-bike-order', [CustomerController::class, 'submitBikeOrder'])->name('customer.submit-bike-order');

    // Orders - view current/pending orders
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');

    // Order details - show specific order information
    Route::get('/customer/orders/{order}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');

    // Order history - view completed/delivered orders
    Route::get('/orders/history', [CustomerController::class, 'orderHistory'])->name('customer.orders.history');

    // Payment processing with Stripe
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('customer.payment');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('customer.payment.process');
    Route::get('/customer/payment/success', [PaymentController::class, 'success'])->name('customer.payment.success');
    Route::get('/customer/payment/cancel', [PaymentController::class, 'cancel'])->name('customer.payment.cancel');

    // Stripe webhook for payment status updates
    Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');


    // About Us - comprehensive information about MyBikeStore and services
    Route::get('/about-us', [CustomerController::class, 'aboutMyBikeShop'])->name('customer.about_us');

    // Live Chat - Add after payment routes
    Route::get('/live-chat', [ChatCustomerController::class, 'liveChat'])->name('customer.live-chat');

});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
| Handles all undefined routes - redirects to login page
*/

Route::fallback(function () {
    return redirect()->route('login');
});
