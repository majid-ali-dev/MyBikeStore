<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Authentication Routes
Route::view('login', 'login')->name('login');
Route::post('loginMatch', [UserController::class, 'login'])->name('loginMatch');
Route::view('register', 'register')->name('register');
Route::post('registerSave', [UserController::class, 'register'])->name('registerSave');
Route::match(['get', 'post'], 'logout', [UserController::class, 'logout'])->name('logout');


// Admin Routes
Route::middleware(['auth', 'admin:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Categories routes
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');

    // Parts routes
    Route::get('/categories/{category}/parts', [AdminController::class, 'categoryParts'])->name('admin.categories.parts');
    Route::get('/categories', [AdminController::class, 'categoriesList'])->name('admin.categories.list');
    Route::get('/categories/{category}/parts/create', [AdminController::class, 'createPart'])->name('admin.parts.create');
    Route::put('/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
    Route::post('/categories/{category}/parts', [AdminController::class, 'storePart'])->name('admin.parts.store');
    Route::put('/parts/{part}', [AdminController::class, 'updatePart'])->name('admin.parts.update');
    Route::delete('/parts/{part}', [AdminController::class, 'destroyPart'])->name('admin.parts.destroy');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/orders', [AdminController::class, 'ordersList'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');

});


// Customer Routes
Route::middleware(['auth', 'customer:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

    Route::get('/bike-builder', [CustomerController::class, 'bikeBuilder'])->name('customer.bike-builder');
    Route::post('/submit-bike-order', [CustomerController::class, 'submitBikeOrder'])->name('customer.submit-bike-order');
    Route::get('/customer/orders/{order}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/orders/history', [CustomerController::class, 'orderHistory'])->name('customer.orders.history');
    Route::get('/customer/orders/{order}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');
    // Stripe
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('customer.payment');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('customer.payment.process');
    Route::get('/customer/payment/success', [PaymentController::class, 'success'])->name('customer.payment.success');
    Route::get('/customer/payment/cancel', [PaymentController::class, 'cancel'])->name('customer.payment.cancel');
    Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');
});

//  Fallback Route - Handles all undefined routes
//  This acts as a catch-all for any requests to routes that haven't been explicitly defined.
Route::fallback(function () {
    return redirect()->route('login');
});


// Login with Google/Socialite
Route::get('/auth/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/callback', [LoginController::class, 'handleGoogleCallback']);

