<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        
        // Load order items if not already loaded
        if (!$this->order->relationLoaded('orderItems')) {
            $this->order->load('orderItems.product');
        }
    }

    public function build()
    {
        return $this->subject('Your Order Has Been Cancelled - Order #' . ($this->order->order_number ?? $this->order->id))
                    ->view('emails.order_cancelled'); // Using the custom view
    }
}
