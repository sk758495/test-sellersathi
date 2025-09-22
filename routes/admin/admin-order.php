<?php

use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Pages\BrandController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Admin Order Routes
    Route::get('/orders', [OrderController::class, 'viewOrders'])->name('admin.orders');
    Route::post('/order/{order}/confirm', [OrderController::class, 'confirmOrder'])->name('admin.order.confirm');
    Route::post('/order/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('admin.order.cancel');
});

// Separate Prefix for Seller Admin Routes
Route::prefix('selleradmin')->middleware('auth:selleradmin')->group(function () {
    Route::post('/order/{order}/confirm', [OrderController::class, 'sellerconfirmOrder'])->name('seller.admin.order.confirm');
    Route::post('/order/{order}/cancel', [OrderController::class, 'sellercancelOrder'])->name('seller.admin.order.cancel');
});

