<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminOtpVerificationPromptController extends Controller
{
    /**
     * Display the OTP verification prompt (disabled).
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();
        
        // Check if the email is verified
        if ($admin->hasVerifiedEmail()) {
            // If email is verified, proceed to the dashboard
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } else {
            // If email is not verified, redirect to email verification page
            return redirect()->route('admin.verification.notice');
        }
    }
}
