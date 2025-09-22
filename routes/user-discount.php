<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Discount\UserDiscountController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('super-sell&discount`offer')->middleware('auth')->group(function () {
 // user
 Route::get('/show-discount-category',[UserDiscountController::class, 'categoryofdiscount'])->name('show-discount-category');
 Route::get('/discounts/{discountPercentage}', [UserDiscountController::class, 'getDiscountedProducts'])->name('user.discountBox');

 // Route to view a single discounted product
Route::get('/discounted-product/{id}', [UserDiscountController::class, 'view_discount_product'])->name('user.view_discount_product');

// Route for adding a discounted product to the cart
Route::get('add_cart/{id}/{discount_id?}', [UserDiscountController::class, 'add_cart'])
    ->middleware(['auth', 'verified'])
    ->name('user.add_cart-new');

});


