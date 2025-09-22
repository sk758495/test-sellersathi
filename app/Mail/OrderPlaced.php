<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use SerializesModels;

    public $order;  // The order object
    public $cartItems;  // Cart items for the order

    // Constructor to accept the order and cartItems
    public function __construct(Order $order, $cartItems)
    {
        $this->order = $order;
        $this->cartItems = $cartItems;  // Store cartItems for email
    }

    // Build the email content
    public function build()
    {
        return $this->subject('Your Order Received')
                    ->view('emails.order_placed');  // Email view file
    }
}
