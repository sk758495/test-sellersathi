<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminCustomVerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminRegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('admin.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validate input data
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Admin::class],
        'phone' => ['required', 'string', 'max:15', 'unique:' . Admin::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Ensure the phone number starts with +91 if not provided
    $phone = $request->phone;
    if (!str_starts_with($phone, '+91')) {
        $phone = '+91' . ltrim($phone, '0');  // Add +91 and remove any leading 0 if present
    }

    // Create admin user
    $admin = Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $phone,
        'password' => Hash::make($request->password),
    ]);

    // Send the custom email verification notification
    $admin->notify(new AdminCustomVerifyEmail());

    // Redirect to the verification notice with success message
    return redirect()->route('admin.verification.notice')->with('success', 'Registration successful! Please verify your email address.');
}

}
