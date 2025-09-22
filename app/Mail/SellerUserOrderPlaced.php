<?php

namespace App\Mail;

use App\Models\SellerOrder;
use App\Models\User;
use App\Models\SellerAdmin;
use App\Models\SellerCart;  // Ensure SellerCart is imported if using this
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerUserOrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $sellerAdmin;
    public $cartItem;  // Add a property for cart item

    /**
     * Create a new message instance.
     *
     * @param SellerOrder|SellerCart $orderOrCart
     * @param User $user
     * @param SellerAdmin $sellerAdmin
     */
    public function __construct($orderOrCart, User $user, SellerAdmin $sellerAdmin)
    {
        // If the passed parameter is an order, assign it to $order
        if ($orderOrCart instanceof SellerOrder) {
            $this->order = $orderOrCart;
            $this->cartItem = null; // No cart item in case of order
        } elseif ($orderOrCart instanceof SellerCart) {
            $this->order = null; // No order in case of cart item
            $this->cartItem = $orderOrCart; // Assign the cart item
        } else {
            // Handle invalid case
            throw new \InvalidArgumentException("Expected either SellerOrder or SellerCart.");
        }

        // Assign common user and sellerAdmin properties
        $this->user = $user;
        $this->sellerAdmin = $sellerAdmin;
    }

    public function build()
    {
        // Choose the appropriate view based on the data available
        return $this->subject('Your Order Request Has Been Received')
                    ->view('emails.seller_orderPlaced')
                    ->with([
                        'order' => $this->order,
                        'cartItem' => $this->cartItem,
                        'user' => $this->user,
                        'sellerAdmin' => $this->sellerAdmin,
                    ]);
    }
}
