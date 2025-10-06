<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;

Route::get('/test-cart-order', function () {
    try {
        // Find a test user (or create one)
        $user = User::first();
        if (!$user) {
            return response()->json(['error' => 'No users found. Please create a user first.']);
        }

        // Find some products
        $products = Product::take(2)->get();
        if ($products->count() < 2) {
            return response()->json(['error' => 'Need at least 2 products to test. Please add products first.']);
        }

        // Clear existing cart for this user
        Cart::where('user_id', $user->id)->delete();

        // Add products to cart
        foreach ($products as $product) {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3)
            ]);
        }

        // Get cart items
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        // Create or get an address
        $address = Address::where('user_id', $user->id)->first();
        if (!$address) {
            $address = Address::create([
                'user_id' => $user->id,
                'address_line1' => 'Test Address Line 1',
                'address_line2' => 'Test Address Line 2',
                'city' => 'Test City',
                'state' => 'Test State',
                'country' => 'India',
                'postal_code' => '123456'
            ]);
        }

        // Calculate totals
        $subtotal = 0;
        $orderItems = [];

        foreach ($cartItems as $cart) {
            $product = $cart->product;
            $price = $product->discount_price;
            $itemTotal = $price * $cart->quantity;
            $subtotal += $itemTotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $cart->quantity,
                'price' => $price,
                'total_price' => $itemTotal,
                'discount_id' => null
            ];
        }

        $shippingCharge = 50;
        $totalPrice = $subtotal + $shippingCharge;

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'order_number' => Order::generateOrderNumber(),
            'subtotal' => $subtotal,
            'shipping_charge' => $shippingCharge,
            'total_price' => $totalPrice,
            'payment_method' => 'TEST',
            'order_status' => 'Confirmed',
            'order_id' => 'TEST' . time(),
            'transaction_id' => 'TXN' . time()
        ]);

        // Create order items
        foreach ($orderItems as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }

        // Clear cart
        Cart::where('user_id', $user->id)->delete();

        // Load order with items for display
        $order->load(['orderItems.product', 'address']);

        return response()->json([
            'success' => true,
            'message' => 'Test order created successfully!',
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_items' => $order->orderItems->count(),
                'subtotal' => $order->subtotal,
                'shipping_charge' => $order->shipping_charge,
                'total_price' => $order->total_price,
                'items' => $order->orderItems->map(function($item) {
                    return [
                        'product_name' => $item->product->product_name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'total' => $item->total_price
                    ];
                })
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Test failed: ' . $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});