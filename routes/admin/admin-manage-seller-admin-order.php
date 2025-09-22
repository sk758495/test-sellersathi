<?php


use App\Http\Controllers\admin\pages\CategoryController;
use App\Http\Controllers\Admin\Seller_Admin_Order\ManageSellerAdminOrder;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('orders/all', [ManageSellerAdminOrder::class, 'showAllOrders'])->name('admin.orders.all');
    // Route to confirm the order
    Route::post('orders/{order}/confirm', [ManageSellerAdminOrder::class, 'confirmOrder'])->name('admin.orders.confirm');

    // Route to cancel the order
    Route::delete('orders/{order}/cancel', [ManageSellerAdminOrder::class, 'cancelOrder'])->name('admin.orders.cancel');

});
