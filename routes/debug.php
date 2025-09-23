<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

// Debug route - remove this in production
Route::get('/debug-orders', function() {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    $orders = Order::with(['address', 'product'])
                  ->where('user_id', auth()->id())
                  ->latest()
                  ->take(5)
                  ->get();
    
    $debug = [];
    foreach ($orders as $order) {
        $debug[] = [
            'id' => $order->id,
            'order_id' => $order->order_id,
            'transaction_id' => $order->transaction_id,
            'payment_method' => $order->payment_method,
            'order_status' => $order->order_status,
            'address_id' => $order->address_id,
            'address_exists' => $order->address ? 'Yes' : 'No',
            'address_data' => $order->address ? [
                'line1' => $order->address->address_line1,
                'city' => $order->address->city,
                'state' => $order->address->state,
                'postal_code' => $order->address->postal_code
            ] : null,
            'created_at' => $order->created_at->format('Y-m-d H:i:s')
        ];
    }
    
    return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
})->name('debug.orders');