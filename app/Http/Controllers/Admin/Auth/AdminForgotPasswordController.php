<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Twilio\Rest\Client;

class AdminForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot_password_mobile');
    }

    public function sendOtp(Request $request)
{
    $request->validate(['phone' => 'required|string']);

    $user = Admin::where('phone', $request->phone)->first();

    if (!$user) {
        return back()->withErrors(['phone' => 'Phone number not found.']);
    }

    // Generate a random 6-digit OTP
    $otp = rand(100000, 999999);

    // Send OTP via SMS
    $this->sendSms($user->phone, "Your password reset OTP is: $otp");

    // Store OTP in session for verification
    session(['otp' => $otp, 'phone' => $user->phone]);

    // Redirect to the reset password form without the token in the URL
    return redirect()->route('admin.password.mobile.reset')->with('success', 'An OTP has been sent to your mobile number.');
}


    private function sendSms($phone, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilioNumber = env('TWILIO_NUMBER');

        $client = new Client($sid, $token);
        $client->messages->create($phone, [
            'from' => $twilioNumber,
            'body' => $message,
        ]);
    }

    public function showResetPasswordForm(Request $request)
{
    if (!session('otp')) {
        return redirect()->route('admin.password.request.mobile')->withErrors(['otp' => 'No OTP sent. Please request a new OTP.']);
    }

    return view('admin.auth.reset_password');
}


    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|string|confirmed',
        ]);

        if ($request->otp != session('otp')) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        $user = Admin::where('phone', session('phone'))->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            session()->forget(['otp', 'phone']);

            return redirect()->route('admin.login')->with('success', 'Password reset successfully. You can now log in with your new password.');
        }

        return back()->withErrors(['phone' => 'User not found.']);
    }
}
