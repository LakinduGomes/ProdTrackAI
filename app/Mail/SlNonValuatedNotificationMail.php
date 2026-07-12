<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SlNonValuatedNotificationMail extends Mailable    
{
    use Queueable, SerializesModels;

    public $details;  // Data passed to the email

    public function __construct($details)
    {
        $this->details = $details;  // Pass dynamic data to the email
    }


    public function build()
    {
        return $this->subject('Sl Non Valuated - Approval')
        ->view('emails.sl-non-valuation-notification');
    }
}
