<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminVerifyOtpController extends Controller
{
    /**
     * Mark the authenticated user's phone number as verified and check email verification.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // Get the authenticated admin
        $admin = $request->user(); // Use $request->user() to get the authenticated user

        // Check if the admin's phone number is already verified
        if ($admin->$admin->hasVerifiedEmail()) {
            // If both the phone and email are verified, redirect to the dashboard
            return redirect()->intended(route('admin.dashboard', absolute: false) . '?verified=1');
        }

        // If the email is not verified, prompt the user to verify their email
        if (!$admin->hasVerifiedEmail()) {
            return redirect()->route('admin.verification.notice');  // Redirect to email verification page
        }

        // Optionally log in the admin (if not already logged in)
        Auth::login($admin);

        // Redirect to the dashboard after verifying the phone
        return redirect()->intended(route('admin.dashboard', absolute: false) . '?verified=1');
    }
}
