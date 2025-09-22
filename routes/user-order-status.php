<?php


use App\Http\Controllers\admin\Order\OrderController;
use App\Http\Controllers\User\Order\OrderStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/order-status', [OrderStatusController::class, 'order_status'])->name('user.orders.status');

});

