<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailOtpNotification;

class OtpController extends Controller
{
    // Send OTP via email (you already have this)
    public function sendOtp(Request $request)
    {
        $user = $request->user();
        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        // Store OTP in session (you can store it in the database if needed)
        Session::put('otp', $otp);
        Session::put('otp_expiry', now()->addMinutes(10)); // OTP will expire in 10 minutes

        // Send OTP via email
        $user->notify(new EmailOtpNotification($otp));

        return view('auth.otp');
    }

    // Handle OTP verification
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $inputOtp = $request->otp;

        if ($inputOtp == Session::get('otp') && now()->lt(Session::get('otp_expiry'))) {
            // OTP is valid and not expired
            $request->user()->markEmailAsVerified();
            return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
        }

        return back()->with('error', 'Invalid or expired OTP. Please try again.');
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $user = $request->user();

        // Generate a new OTP
        $otp = rand(100000, 999999);

        // Store the new OTP in session
        Session::put('otp', $otp);
        Session::put('otp_expiry', now()->addMinutes(10)); // Reset OTP expiration time

        // Send the OTP via email
        $user->notify(new EmailOtpNotification($otp));

        return back()->with('success', 'A new OTP has been sent to your email.');
    }
}
