<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMe extends Mailable
{
    use Queueable, SerializesModels;

    public $message = null;
    public $name    = null;
    public $mail    = null;
    public $subject = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $name, $mail, $subject)
    {
         $this->message = $message;
         $this->name    = $name;
         $this->mail    = $mail;
         $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact-me')
                  ->from($this->mail)
                  ->subject($this->subject);
    }
}
