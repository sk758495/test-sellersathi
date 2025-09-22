<?php

namespace App\Http\Controllers\SellerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerAdmin;

class SellerAdminLoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('seller-admin.seller-admin-login');
    }

    // Handle login request
public function login(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    // Attempt to log the seller admin in
    if (Auth::guard('seller-admin')->attempt([
        'email' => $request->email,
        'password' => $request->password,
    ], $request->remember)) {
        // Find the logged-in seller admin's ID
        $sellerAdminId = Auth::guard('seller-admin')->user()->id;

        // Redirect to the intended page (usually the dashboard), passing the sellerAdminId
        return redirect()->route('seller.products.select', ['sellerAdminId' => $sellerAdminId]);
    }

    // If authentication fails, redirect back with an error
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


    // Handle logout
    public function logout()
    {
        Auth::guard('seller-admin')->logout();

        return redirect()->route('seller-admin.login');
    }
}
