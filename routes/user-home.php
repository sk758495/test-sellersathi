<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'dashboard']);
Route::get('products/product/{id}', [UserController::class, 'view_product'])->name('user.view_product');

Route::get('/all_product-show-here', [UserController::class, 'all_product_show_here'])->name('user.all_product_show_here');

Route::get('/category_page', [UserController::class, 'category_page'])->name('user.category_page');

Route::get('/gujju_category_products/{id}', [UserController::class, 'gujju_category_products'])->name('user.gujju_category_products');

Route::get('/category_products/{id}', [UserController::class, 'category_products'])->name('user.category_products');
// In routes/web.php
Route::get('/brand_category/{brandId}', [UserController::class, 'showBrandCategory'])->name('user.brand_category');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/cart', [UserController::class, 'view_cart'])->name('user.cart');

    Route::get('add_cart/{id}', [UserController::class, 'add_cart'])->middleware(['auth', 'verified'])->name('user.add_cart');

    Route::post('/update-cart-quantity', [UserController::class, 'updateCartQuantity'])->name('update.cart.quantity');

    Route::delete('/remove-from-cart', [UserController::class, 'removeFromCart'])->name('remove.from.cart');


    //Payment Route

    Route::get('/payment', [PaymentController::class, 'view_payment'])->name('user.payment');
    Route::post('/user/save-address', [PaymentController::class, 'saveAddress'])->name('user.save_address');
// Route to select an existing address
    Route::post('/select-address', [PaymentController::class, 'selectAddress'])->name('user.select_address');


    Route::get('/payment_page', [PaymentController::class, 'payment_page'])->name('user.payment.payment_page');

    Route::post('/place-order', [PaymentController::class, 'placeOrder'])->name('user.placeOrder');

    Route::get('/user/orders/{order}', [PaymentController::class, 'showOrderDetails'])->name('user.order.details');
});


