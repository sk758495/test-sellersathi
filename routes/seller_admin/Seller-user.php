<?php

use App\Http\Controllers\SellerAdmin\SellerAdminController;
use App\Http\Controllers\SellerAdmin\SellerAdminLoginController;
use App\Http\Controllers\SellerAdmin\SellerAdminProductController;
use App\Http\Controllers\SellerUser\CartController;
use App\Http\Controllers\SellerUser\SellerOrderController;
use App\Http\Controllers\SellerUser\SellerUserProductController;
use Illuminate\Support\Facades\Route;

    Route::get('/seller-user/dashboard/{sellerAdminId}', [SellerUserProductController::class, 'showDashboard'])
        ->name('seller-user.dashboard');


        // Show details of a single product for a specific seller
    Route::get('/seller-user/{sellerAdminId}/product/{productId}', [SellerUserProductController::class, 'showProductDetails'])
    ->name('seller-user.product-details');



    Route::post('/seller-user/{sellerAdminId}/product/{productId}/add-to-cart', [CartController::class, 'addToCart'])
    ->name('seller.cart.add');

    // View cart for a specific seller
    Route::get('/seller-user/{sellerAdminId}/cart', [CartController::class, 'viewCart'])
        ->name('seller.cart.view');

        Route::post('/update-cart-quantity', [CartController::class, 'updateCartQuantity'])->name('cart.update');

        // Route to remove item from cart
        Route::delete('/seller-user/{sellerAdminId}/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])
        ->name('seller.cart.remove');


        // Route to display the address page
Route::get('/user/addresses/{sellerAdminId}', [CartController::class, 'showAddressPage'])->name('seller-user.address.page');

// Route to save a new address for the logged-in user
Route::post('/user/addresses/{sellerAdminId}/save', [CartController::class, 'saveAddress'])->name('seller-user.save_address');

// Route to select a delivery address for a specific seller
Route::post('/user/addresses/{sellerAdminId}/select', [CartController::class, 'selectAddress'])
    ->name('seller-user.select_address');

    // Show the payment page where the user selects a payment method
Route::get('/user/payment/{sellerAdminId}', [CartController::class, 'showPaymentPage'])
->name('seller-user.payment.payment_page');

// Place the order after payment method selection
Route::post('/user/payment/place-order/{sellerAdminId}', [CartController::class, 'placeOrder'])
    ->name('seller-user.placeOrder');


Route::post('/seller-user/{sellerAdminId}/save-cart-details', [CartController::class, 'saveCartDetails'])
    ->name('seller.cart.save_details');

    Route::get('order/{orderId}/{sellerAdminId}', [CartController::class, 'showOrderdetails'])->name('order.confirmation');



    //trace order
    Route::middleware('auth')->get('track-order/{sellerAdminId}', [SellerOrderController::class, 'trackOrder'])->name('order.track');




    // Route::get('/seller/orders/{orderId}', [CartController::class, 'showOrder'])->name('orders.show');
