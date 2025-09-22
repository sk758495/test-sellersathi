<?php

use App\Http\Controllers\Admin\Discount\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\Discount\UserDiscountController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/add/discounts', [DiscountController::class, 'show_add_discount'])->name('dashboard.viewdiscounts');
    Route::post('/store-discount', [DiscountController::class, 'store'])->name('admin.storeDiscount');
    Route::get('/discounts', [DiscountController::class, 'index'])->name('dashboard.discounts');

    Route::delete('/admin/discount/{id}', [DiscountController::class, 'destroy'])->name('admin.discount.destroy');
    
});
