<?php

use App\Models\Order;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Debug route to check address relationships
Route::get('/debug/address-orders', function() {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    $user = auth()->user();
    $orders = Order::with(['address', 'user', 'product'])
                   ->where('user_id', $user->id)
                   ->latest()
                   ->take(5)
                   ->get();
    
    $debug = [
        'user_id' => $user->id,
        'user_addresses' => $user->addresses->toArray(),
        'recent_orders' => []
    ];
    
    foreach ($orders as $order) {
        $debug['recent_orders'][] = [
            'order_id' => $order->id,
            'order_ref' => $order->order_id,
            'address_id' => $order->address_id,
            'address_data' => $order->address ? $order->address->toArray() : null,
            'payment_method' => $order->payment_method,
            'created_at' => $order->created_at
        ];
    }
    
    return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
})->middleware('auth')->name('debug.address.orders');

// Debug route to check session data
Route::get('/debug/session', function() {
    return response()->json([
        'session_data' => session()->all(),
        'selected_address_id' => session('selected_address_id'),
        'payment_address_id' => session('payment_address_id'),
        'user_id' => auth()->id()
    ], 200, [], JSON_PRETTY_PRINT);
})->middleware('auth')->name('debug.session');

// Debug route to check recent orders with null address_id
Route::get('/debug/null-addresses', function() {
    $nullAddressOrders = Order::whereNull('address_id')
                             ->with(['user', 'product'])
                             ->latest()
                             ->take(10)
                             ->get();
    
    return response()->json([
        'null_address_orders_count' => $nullAddressOrders->count(),
        'orders' => $nullAddressOrders->toArray()
    ], 200, [], JSON_PRETTY_PRINT);
})->middleware('auth')->name('debug.null.addresses');