<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\SellerOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthenticatedSessionController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function dashboard()
    {
        // Get all orders, sorted by created_at in descending order (most recent first)
        $orders = Order::latest()->get();
    
        // Calculate the total amount of all orders
        $totalAmount = $orders->sum('total_price');
    
        // Calculate the total number of products sold (sum of quantities)
        $totalProductsSold = $orders->sum('quantity');
    
        // Calculate the total number of orders
        $totalOrdersReceived = $orders->count();
    
        // Get confirmed orders (assuming 'status' column for order status)
        $confirmedOrders = $orders->where('status', 'confirmed');
        $totalConfirmedOrders = $confirmedOrders->count();
        $totalConfirmedPrice = $confirmedOrders->sum('total_price');
    
        // Get cancelled orders (assuming 'status' column for order status)
        $cancelledOrders = $orders->where('status', 'cancelled');
        $totalCancelledOrders = $cancelledOrders->count();
        $totalCancelledPrice = $cancelledOrders->sum('total_price');
    
        // Return the dashboard view with all data
        return view('admin.dashboard', compact(
            'orders', 'totalAmount', 'totalProductsSold', 'totalOrdersReceived',
            'totalConfirmedOrders', 'totalConfirmedPrice', 'totalCancelledOrders', 'totalCancelledPrice'
        ));
    }
    /**
     * Show the login page.
     */
    public function create(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle the incoming authentication request.
     */
    public function store(Request $request)
{
    // Validate the login form input (accept both email and mobile)
    $request->validate([
        'login' => 'required',  // Accept both email and mobile
        'password' => 'required',
    ]);

    // Ensure phone number starts with +91 if it's not already there
    $loginInput = $request->login;

    if (preg_match('/^\d{10}$/', $loginInput)) {
        // If the login input is a 10-digit number (no country code), prepend +91
        $loginInput = '+91' . $loginInput;
    }

    // Attempt to find the admin user by email or phone number
    $admin = Admin::where('email', $loginInput)
                  ->orWhere('phone', $loginInput)
                  ->first();

    if ($admin) {
        // Check if the admin logs in with email and the email is not verified
        if ($request->login === $admin->email && !$admin->hasVerifiedEmail()) {
            return redirect()->route('admin.verification.notice')->withErrors([
                'login' => 'Please verify your email address before logging in.',
            ]);
        }

        // Proceed to log in if both mobile and email are verified
        if (Auth::guard('admin')->attempt(['email' => $request->login, 'password' => $request->password]) ||
            Auth::guard('admin')->attempt(['phone' => $request->login, 'password' => $request->password])) {

            Auth::guard('admin')->login($admin);
            // Regenerate session after successful login
            $request->session()->regenerate();

            // Check if the admin's email is verified
            if ($admin->hasVerifiedEmail()) {
                return redirect()->intended('admin/dashboard')->with('success', 'Welcome to your Admin Panel.'); // Redirect to dashboard
            } else {
                // If email is not verified, prompt for email verification
                return redirect()->route('admin.verification.notice');
            }
        }
    }

    // If no matching admin or incorrect credentials
    return back()->withErrors([
        'login' => 'The provided credentials do not match our records.',
    ]);
}


    /**
     * Admin Destroy an authenticated session (logout).
     */
    public function admindestroy(Request $request)
    {
        // Log out the admin and invalidate the session
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'You are successfully logged out.');
    }
}
