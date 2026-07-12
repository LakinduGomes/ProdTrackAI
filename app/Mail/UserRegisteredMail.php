<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userEmail;

    // Receive email in constructor
    public function __construct($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function build()
    {
        /* return $this->subject('Customer Notification')
             ->from('ithelpdesk@ceatsrilanka.com', 'CEAT IT Help Desk') // <- ADD THIS if not already
             ->view('emails.user_registered');*/


        return $this->subject('Customer Notification')
            ->view('emails.user_registered');
    }
}