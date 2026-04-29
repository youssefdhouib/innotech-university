<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $link;

    public function __construct($application, $link)
    {
        $this->application = $application;
        $this->link = $link;
    }

    public function build()
    {
        return $this
            ->subject('Votre préinscription a été validée - Université InnoTech')
            ->markdown('emails.applications.accepted');
    }
}
