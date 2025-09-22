<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\EmailOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required', // This will accept both email and mobile
            'password' => 'required',
        ]);

        // Check if the user exists by email or phone
        $user = User::where('email', $request->login)
                    ->orWhere('phone', $request->login)
                    ->first();

        if ($user) {
            // Check if the email is verified
            if (!$user->hasVerifiedEmail()) {
                // If email is not verified, generate a new OTP and redirect to the OTP page
                $otp = rand(100000, 999999);  // Generate a new OTP
                Session::put('otp', $otp);
                Session::put('otp_expiry', now()->addMinutes(10));  // OTP expiry in 10 minutes

                // Send OTP via email
                $user->notify(new EmailOtpNotification($otp));

                // Store user info in session to remember for OTP verification
                session(['user_for_otp' => $user]);

                // Redirect to OTP verification page
                return redirect()->route('verify.otp')->with('success', 'Please verify your email address.');
            }

            // If the email is verified, proceed to login
            if (Auth::guard('web')->attempt(['email' => $request->login, 'password' => $request->password]) ||
                Auth::guard('web')->attempt(['phone' => $request->login, 'password' => $request->password])) {

                $request->session()->regenerate();
                return redirect()->intended('dashboard')->with('success', 'Welcome Boss.');
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        return redirect('/')->with('info', 'See you soon Boss.');
    }
}
