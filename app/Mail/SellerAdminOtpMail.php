<?php

// app/Mail/SellerAdminOtpMail.php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerAdminOtpMail extends Mailable
{
    use SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your OTP for Email Verification')
                    ->view('emails.seller_admin_otp');
    }
}
