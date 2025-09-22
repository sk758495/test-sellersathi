<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\View\View;
use Illuminate\Support\Str;
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request)
    {
        // Validate email
        $request->validate(['email' => 'required|email']);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate OTP
            $otp = rand(100000, 999999);
            Session::put('otp', $otp);
            Session::put('otp_expiry', now()->addMinutes(10));

            // Generate password reset token
            $token = Str::random(60); // Token for password reset

            // Save token in database (optional, for advanced tracking)
            // You could also store this token in a table like `password_resets` if desired
            Session::put('reset_token', $token);

            // Send OTP via email
            $user->notify(new CustomResetPasswordNotification($otp));

            return redirect()->route('password.verifyOtp')->with('status', 'OTP sent. Please verify.');
        }

        return back()->withErrors(['email' => 'We couldn\'t find a user with that email address.']);
    }

    // Show OTP verification page
    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    // Verify OTP and proceed to reset password
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $storedOtp = Session::get('otp');
        $otpExpiry = Session::get('otp_expiry');

        if ($request->otp == $storedOtp && now()->lessThan($otpExpiry)) {
            // OTP is valid, pass the reset token to password reset view
            return redirect()->route('password.reset', ['token' => Session::get('reset_token')]);
        }

        return back()->withErrors(['otp' => 'Invalid OTP or OTP expired.']);
    }
}
