<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Removed Twilio import as it's not needed
// use Twilio\Rest\Client;

class AdminOtpController extends Controller
{
    // Show OTP verification form (no longer used, as OTP is disabled)
    public function showVerifyForm()
    {
        return view('admin.auth.verify_otp'); // You can redirect directly to the reset password form now.
    }

    // Send OTP to admin phone (disabled)
    public function sendOtp(Request $request)
    {
        // Validate phone number input
        $request->validate(['phone' => 'required|string']);

        // Retrieve admin by phone number
        $admin = Admin::where('phone', $request->phone)->first();

        if (!$admin) {
            return back()->withErrors(['error' => 'Phone number not found.']);
        }

        // Disable OTP logic completely. Just store the phone number in session.
        session(['phone' => $admin->phone]);

        // Redirect to reset password page
        return redirect()->route('admin.password.mobile.reset')->with('success', 'Phone number found. Please reset your password.');
    }

    // Disabled OTP helper function (SMS via Twilio)
    // private function sendSms($phone, $message)
    // {
    //     $sid = env('TWILIO_SID');
    //     $token = env('TWILIO_TOKEN');
    //     $twilioNumber = env('TWILIO_NUMBER');

    //     // Check if Twilio credentials are set
    //     if (empty($sid) || empty($token) || empty($twilioNumber)) {
    //         throw new \Exception("Twilio credentials are missing.");
    //     }

    //     $client = new Client($sid, $token);
    //     $client->messages->create($phone, [
    //         'from' => $twilioNumber,
    //         'body' => $message,
    //     ]);
    // }

    // Verify OTP input by the user (disabled)
    public function verifyOtp(Request $request)
    {
        // OTP verification is no longer required, so you can skip this
        return back()->withErrors(['otp' => 'OTP verification is disabled.']);
    }

    // Resend OTP to the phone number (disabled)
    public function resendOtp(Request $request)
    {
        // OTP resend is no longer required, you can just store phone number in session
        $request->validate(['phone' => 'required|string']);

        // Retrieve admin by phone number
        $admin = Admin::where('phone', $request->phone)->first();

        if (!$admin) {
            return back()->withErrors(['phone' => 'Phone number not found.']);
        }

        // Store phone number in session (no OTP)
        session(['phone' => $admin->phone]);

        return back()->with('success', 'Phone number found. Please reset your password.');
    }

    // Show the form for editing the phone number
    public function editNumber()
    {
        return view('auth.phone-number'); // Your phone number edit view
    }

    // Update the admin's phone number
    public function updateNumber(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        // Retrieve the admin by phone number or other identifier (like session phone)
        $admin = Admin::where('phone', session('phone'))->first();

        if (!$admin) {
            return back()->withErrors(['phone' => 'Admin not found.']);
        }

        // Update the admin's phone number
        $admin->phone = $request->phone;
        $admin->phone_verified_at = null; // Reset verification status if needed
        $admin->save();

        // Update the session with the new phone number
        session(['phone' => $request->phone]);

        // Optionally, you can send a new OTP or just redirect to the reset page
        return redirect()->route('admin.password.mobile.reset')->with('success', 'Phone number updated.');
    }

    // Forgot password view for mobile
    public function forgotPassword()
    {
        return view('auth.mobile-forgot-password'); // Your mobile forgot password view
    }
}
