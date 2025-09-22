<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;

    // Constructor to accept dynamic data
    public function __construct($name, $email, $subject, $messageContent)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
    }

    // Build the message
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.contact_form_submission')
                    ->with([
                        'name' => $this->name,
                        'messageContent' => $this->messageContent,
                    ]);
    }
}
