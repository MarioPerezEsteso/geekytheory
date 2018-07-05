<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    const SUBJECT = 'Hemos recibido tu solicitud de contacto';

    /** @var string */
    public $name;

    /** @var string */
    public $formMessage;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $formMessage
     */
    public function __construct(string $name, string $formMessage)
    {
        $this->name = $name;
        $this->formMessage = $formMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.contact-form.acknowledge-email')
            ->subject(self::SUBJECT);
    }
}
