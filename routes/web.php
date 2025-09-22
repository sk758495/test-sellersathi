<?php

use App\Http\Controllers\Admin\Discount\DiscountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProductController;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.product.search');


require __DIR__ . '/auth.php';

require __DIR__ . '/user-home.php';

require __DIR__ . '/user-discount.php';

require __DIR__ . '/user-order-status.php';



// Admin Routes
require __DIR__ . '/admin/admin-auth.php';

require __DIR__ . '/admin/admin-pages.php';

require __DIR__ . '/admin/admin-category.php';

require __DIR__ . '/admin/admin-product.php';

require __DIR__ . '/admin/admin-order.php';

require __DIR__ . '/admin/admin-discount.php';

require __DIR__ . '/admin/admin-carousel.php';

require __DIR__ . '/admin/admin-gujju-category.php';

require __DIR__ . '/admin/admin-manage-seller-admin-order.php';

require __DIR__ . '/admin/admin-selleradmin-account.php';


//Seller Admin Route
require __DIR__ . '/seller_admin/Seller-admin.php';

require __DIR__ . '/seller_admin/Seller-user.php';


require __DIR__ . '/footer-details.php';

require __DIR__ . '/seller_admin/bankdetails.php';
// routes/web.php


// email otp functionality
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\OtpController;

Route::get('/verify-otp', [OtpVerificationController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp']);
Route::post('/resend-otp', [OtpController::class, 'resendOtp'])->name('otp.resend');

use App\Http\Controllers\Auth\PasswordResetLinkController;

// Show forgot password form
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

// Handle forgot password form (send OTP)
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// Show OTP verification form
Route::get('/forgot-password/verify-otp', [PasswordResetLinkController::class, 'showOtpForm'])->name('password.verifyOtp');

// Verify OTP
Route::post('/forgot-password/verify-otp', [PasswordResetLinkController::class, 'verifyOtp'])->name('password.verifyOtp');

// Show password reset form (after OTP is verified)
Route::get('/forgot-password/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

// Handle password reset request
Route::post('/forgot-password/reset-password', [NewPasswordController::class, 'store'])->name('password.store');




    // Route::get('/dashboard/add/discounts', [DiscountController::class, 'show_add_discount'])->name('dashboard.viewdiscounts');
    // Route::post('/admin/store-discount', [DiscountController::class, 'store'])->name('admin.storeDiscount');
    // Route::get('/dashboard/discounts', [DiscountController::class, 'index'])->name('dashboard.discounts');

    // // user
    // Route::get('/discounts/{discountPercentage}', [DiscountController::class, 'getDiscountedProducts'])->name('user.discountBox');
