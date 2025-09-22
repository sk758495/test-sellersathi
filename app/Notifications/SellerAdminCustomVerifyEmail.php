<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class SellerAdminCustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Generate the verification URL.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'selleradmin.verification.verify', // Use the admin verification route
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), // Set expiration time
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    /**
     * Build the email for the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Please Verify Your Email Address')
            ->view('emails.selleradmin_verification', [ // Use a custom view for admin verification
                'verificationUrl' => $verificationUrl,
                'notifiable' => $notifiable,
            ]);
    }
}


