<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OtpVerificationController extends Controller
{
    /**
     * Display the OTP verification form.
     */
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    /**
     * Verify the OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        // Get the OTP and expiry time from the session
        $otp = Session::get('otp');
        $otpExpiry = Session::get('otp_expiry');

        // Check if the OTP has expired
        if (!$otp || now()->gt($otpExpiry)) {
            // Clear OTP session data
            Session::forget(['otp', 'otp_expiry']);
            return redirect()->back()->with('error', 'OTP has expired. Please request a new OTP.');
        }

        // Check if the OTP is correct
        if ($request->otp == $otp) {
            // Retrieve the user from session
            $user = session('user_for_otp');

            // Mark the user's email as verified
            if ($user) {
                $user->markEmailAsVerified();

                // Clear OTP session data after verification
                Session::forget(['otp', 'otp_expiry']);

                // Log the user in
                Auth::login($user);

                // Redirect to the dashboard or home page
                return redirect()->route('dashboard')->with('success', 'Email successfully verified!');
            }

            return redirect()->route('login')->with('error', 'User not found or session expired.');
        }

        return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
    }

}
