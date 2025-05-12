<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Authentication Routes (Keep existing)
Route::view('login', 'login')->name('login');
Route::post('loginMatch', [UserController::class, 'login'])->name('loginMatch');
Route::view('register', 'register')->name('register');
Route::post('registerSave', [UserController::class, 'register'])->name('registerSave');
Route::match(['get', 'post'], 'logout', [UserController::class, 'logout'])->name('logout');


// Customer Routes
Route::middleware(['auth', 'customer:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

});

// Admin Routes
Route::middleware(['auth', 'admin:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

});


// Login with Google
Route::get('/auth/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/callback', [LoginController::class, 'handleGoogleCallback']);

