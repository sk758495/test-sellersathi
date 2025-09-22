<?php

use App\Http\Controllers\SellerAdmin\SellerAdminController;
use App\Http\Controllers\SellerAdmin\SellerAdminLoginController;
use App\Http\Controllers\SellerAdmin\SellerAdminOrderController;
use App\Http\Controllers\SellerAdmin\SellerAdminProductController;
use Illuminate\Support\Facades\Route;


// Seller Admin Account Creation route

Route::prefix('seller-admin')->group(function () {
    // Route to view all SellerAdmins
    Route::get('/', [SellerAdminController::class, 'index'])->name('seller-admin.index');

    // Route to create a new SellerAdmin
    Route::get('create', [SellerAdminController::class, 'create'])->name('seller-admin.create');
    Route::post('store', [SellerAdminController::class, 'store'])->name('seller-admin.store');
    // OTP Verification Route
    Route::get('seller-admin/verify/{id}', [SellerAdminController::class, 'showOtpForm'])->name('seller-admin.verify');
    Route::post('seller-admin/verify/{id}', [SellerAdminController::class, 'verifyOtp'])->name('seller-admin.verify.otp');

    // Route::get('verify/{id}', [SellerAdminController::class, 'verifyOtp'])->name('seller-admin.verify');

    // Route to edit an existing SellerAdmin
    Route::get('edit/{id}', [SellerAdminController::class, 'edit'])->name('seller-admin.edit');
    Route::post('update/{id}', [SellerAdminController::class, 'update'])->name('seller-admin.update');

    // Route to delete a SellerAdmin
    Route::delete('delete/{id}', [SellerAdminController::class, 'destroy'])->name('seller-admin.destroy');
});

// Seller Admin Login Functionality

Route::prefix('seller-admin')->group(function () {
    // Show login form
    Route::get('login', [SellerAdminLoginController::class, 'showLoginForm'])->name('seller-admin.login');

    // Handle login request
    Route::post('login', [SellerAdminLoginController::class, 'login'])->name('seller-admin.login');

    // Handle logout request
    Route::post('logout', [SellerAdminLoginController::class, 'logout'])->name('seller-admin.logout');
});


// Seller Admin All Pages

Route::prefix('seller-admin')->middleware('auth:seller-admin')->group(function () {
    // Route to display the select Admin product page


    Route::get('dashboard/{sellerAdminId}', [SellerAdminController::class, 'dashboard'])->name('seller-admin.dashboard');

    Route::get('products/select/{sellerAdminId}', [SellerAdminProductController::class, 'showAdminProducts'])->name('seller.products.select');  //this is my dashboard

    Route::get('products/{adminProductId}/add/{sellerAdminId}', [SellerAdminProductController::class, 'addProductToSellerStore'])->name('seller.products.add');  //this is add functionality

        // Route to update the discount price of a product
    Route::post('products/{productId}/update-discount', [SellerAdminProductController::class, 'updateDiscountPrice'])
    ->name('seller.products.updateDiscount');

    // Route to delete a product from seller's store
    Route::delete('products/{productId}/delete', [SellerAdminProductController::class, 'deleteProduct'])
    ->name('seller.products.delete');

     // Seller Orders - received orders
     Route::get('orders/received/{sellerAdminId}', [SellerAdminOrderController::class, 'receivedOrders'])->name('seller-admin.orders.received');

     Route::get('orders/view/{orderId}/{sellerAdminId}', [SellerAdminOrderController::class, 'viewOrder'])->name('seller-admin.orders.view');


     Route::get('order/{orderId}/invoice/{sellerAdminId}/download', [SellerAdminOrderController::class, 'downloadOrderInvoice'])
     ->name('seller-admin.orders.downloadInvoice');

});
