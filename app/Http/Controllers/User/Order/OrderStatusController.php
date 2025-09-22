<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\OrderPlaced;

class OrderStatusController extends Controller
{
    public function order_status()
    {
        // Fetch the orders for the authenticated user
        $orders = Order::where('user_id', auth()->user()->id)->latest()->get();

        $brand_categories = BrandCategory::with('images')->take(6)->get();

        // Get the first order (or a specific one if needed)
        $order = $orders->first();

        // Fetch cart items related to the order
        $cartItems = Cart::where('user_id', auth()->user()->id)->with('product')->get();

        // Check if the email has already been sent for this order (using the email_sent column)
        if ($order && !$order->email_sent) {
            // Send the order details via email (passing both $order and $cartItems)
            Mail::to(auth()->user()->email)->send(new OrderPlaced($order, $cartItems));

            // Update the email_sent column to true after sending the email
            $order->email_sent = true;
            $order->save();
        }

        // Return the view with the orders
        return view('user.order.order-status', compact('orders', 'brand_categories'));
    }
}
