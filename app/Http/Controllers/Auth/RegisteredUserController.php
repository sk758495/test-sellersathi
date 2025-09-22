<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Notifications\EmailOtpNotification;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validate incoming registration data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:15', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in
        Auth::login($user);

        // Store the user in session for OTP verification
        Session::put('user_for_otp', $user);

        // Generate and send OTP
        $otp = rand(100000, 999999);  // Generate a random 6-digit OTP
        Session::put('otp', $otp);
        Session::put('otp_expiry', now()->addMinutes(10));  // OTP expiry in 10 minutes

        // Send OTP via email
        $user->notify(new EmailOtpNotification($otp));

        // Redirect to OTP verification page
        return redirect()->route('verify.otp');
    }

}
