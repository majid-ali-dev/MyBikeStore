<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController
{
    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        // Validate registration form fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:5|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        // Create new user with hashed password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'customer' // Default role
        ]);

        // If user created successfully
        if ($user) {
            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login.');
        }

        // If user creation fails
        return back()->with('error', 'Registration failed. Please try again.');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        // Validate login form fields
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Redirect based on user role
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }

        // If login fails, send error to view
        return back()->withErrors([
            'email' => 'Invalid credentials. Please check your email or password.',
        ]);
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        Auth::logout(); // Logout user
        return redirect()->route('login'); // Redirect to login page
    }
}
