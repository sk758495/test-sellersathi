<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
{
    // Use the correct method to get the authenticated admin
    $admin = Auth::guard('admin')->user();

    if ($admin->hasVerifiedEmail()) {
        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    $admin->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
}

}
