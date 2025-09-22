<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class AdminVerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $admin = $request->user();

        // If the email is already verified, redirect to the dashboard
        if ($admin->hasVerifiedEmail()) {
            return redirect()->intended(route('admin.dashboard', absolute: false) . '?verified=1');
        }

        // Mark the email as verified
        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin)); // Fire the verified event
        }

        // Redirect to dashboard after verification
        return redirect()->intended(route('admin.dashboard', absolute: false) . '?verified=1');
    }
}
