<?php

namespace App\Http\Controllers\admin\Order;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SellerOrder;
use Illuminate\Http\Request;
use App\Mail\OrderCancelled; // Import the new Mailable
use App\Mail\OrderConfirmed; // Import the Mailable
use Illuminate\Support\Facades\Mail; // Import the Mail facade

class OrderController extends Controller
{
    // Method to view all orders
    public function viewOrders()
    {
        // Get unique orders with payment attempts count
        $orders = Order::with(['user', 'product.category', 'product.brandCategory'])
            ->selectRaw('orders.*, 1 as transaction_count')
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')
                      ->from('orders')
                      ->groupBy('order_id');
            })
            ->latest()
            ->get();

        // Pass orders to the view
        return view('admin.orders.order', compact('orders'));
    }

    // Method to confirm an order
    public function confirmOrder(Order $order)
    {
        // Change order status to 'Confirmed'
        $order->order_status = Order::STATUS_CONFIRMED;
        $order->save();

        // Send the confirmation email to the user
        Mail::to($order->user->email)->send(new OrderConfirmed($order));

        // Redirect back with success message
        return redirect()->route('admin.orders')->with('success', 'Order confirmed successfully!');
    }

    // Method to cancel an order
    public function cancelOrder(Order $order)
    {
        // Change order status to 'Cancelled'
        $order->order_status = Order::STATUS_CANCELLED;
        $order->save();

        // Send the cancellation email to the user
        Mail::to($order->user->email)->send(new OrderCancelled($order));

        // Redirect back with success message
        return redirect()->route('admin.orders')->with('error', 'Order cancelled successfully!');
    }




}
