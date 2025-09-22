<?php

use App\Http\Controllers\Admin\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\AdminConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\AdminEmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\AdminEmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminNewPasswordController;
use App\Http\Controllers\Admin\Auth\AdminOtpController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\AdminRegisteredUserController;
use App\Http\Controllers\Admin\Auth\AdminVerifyEmailController;
use App\Http\Controllers\Admin\Auth\AdminPasswordController;
use Illuminate\Support\Facades\Route;




Route::prefix('admin')->middleware('guest:admin')->group(function () {

    Route::get('form-gujju_e-market_admin-new-register', [AdminRegisteredUserController::class, 'create'])->name('admin.register');

    Route::post('form-gujju_e-market_admin-new-register', [AdminRegisteredUserController::class, 'store']);

    Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('admin.login');

    Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);


    Route::get('/verify-otp', [AdminOtpController::class, 'showVerifyForm'])->name('admin.verify.otp');
    Route::post('/send-otp', [AdminOtpController::class, 'sendOtp'])->name('admin.send.otp');
    Route::post('/verify-otp', [AdminOtpController::class, 'verifyOtp'])->name('admin.verify.otp');
    Route::post('/resend-otp', [AdminOtpController::class, 'resendOtp'])->name('admin.resend.otp');
    Route::get('/edit-phone-number', [AdminOtpController::class, 'editNumber'])->name('edit.phone.number');
Route::post('/update-phone-number', [AdminOtpController::class, 'updateNumber'])->name('update.phone.number');

// Show the form to request a password reset via mobile
Route::get('/forgot-password-mobile', [AdminForgotPasswordController::class, 'showForgotPasswordForm'])->name('admin.password.request.mobile');

// Handle the mobile number input and send OTP
Route::post('/forgot-password-mobile', [AdminForgotPasswordController::class, 'sendOtp'])->name('admin.password.mobile.send.otp');

// Show the form to reset the password after OTP verification
Route::get('/mobile-reset-password', [AdminForgotPasswordController::class, 'showResetPasswordForm'])->name('admin.password.mobile.reset');

// Handle the password update
Route::post('/mobile-reset-password', [AdminForgotPasswordController::class, 'resetPassword'])->name('admin.password.mobile.update');


    Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])->name('admin.password.request');

    Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])->name('admin.password.email');

    Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])->name('admin.password.reset');

    Route::post('reset-password', [AdminNewPasswordController::class, 'store'])->name('admin.password.store');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('dashboard', [AdminAuthenticatedSessionController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('verify-email', [AdminEmailVerificationPromptController::class, '__invoke'])->name('admin.verification.notice');


    Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)->name('admin.verification.verify');

    Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('admin.verification.send');

    Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])->name('admin.password.confirm');

    Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);

    Route::put('password', [AdminPasswordController::class, 'update'])->name('admin.password.update');


    Route::post('logout', [AdminAuthenticatedSessionController::class, 'admindestroy'])->name('admin.logout');
});
