<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Send the custom OTP email using the blade template
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Password Reset OTP')
            ->view('emails.otp_reset', ['otp' => $this->otp]);
    }
}


