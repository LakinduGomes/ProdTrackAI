<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SendMail extends Mailable
{
    public function build()
    {
        return $this->subject('Test Email from Azure')
            ->view('emails.test');
    }
}
