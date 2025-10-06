<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use SerializesModels;

    public $order;  // The order object
    public $cartItems;  // Cart items for the order (for backward compatibility)

    // Constructor to accept the order and cartItems
    public function __construct(Order $order, $cartItems = null)
    {
        $this->order = $order;
        $this->cartItems = $cartItems;  // Store cartItems for email (optional for new structure)
        
        // Load order items if not already loaded
        if (!$this->order->relationLoaded('orderItems')) {
            $this->order->load('orderItems.product');
        }
    }

    // Build the email content
    public function build()
    {
        return $this->subject('Your Order Received - Order #' . ($this->order->order_number ?? $this->order->id))
                    ->view('emails.order_placed');  // Email view file
    }
}
