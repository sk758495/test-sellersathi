<?php

namespace App\Mail;

use App\Models\SellerOrder;
use App\Models\SellerAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $sellerAdmin;

    /**
     * Create a new message instance.
     *
     * @param SellerOrder $order
     * @param SellerAdmin $sellerAdmin
     */
    public function __construct(SellerOrder $order, SellerAdmin $sellerAdmin)
    {
        $this->order = $order;
        $this->sellerAdmin = $sellerAdmin;
    }

    public function build()
    {
        return $this->subject('New Order Request Received')
                    ->view('emails.admin_new_order') // Use the view for admin notification
                    ->with([
                        'order' => $this->order,
                        'sellerAdmin' => $this->sellerAdmin,
                    ]);
    }
}
