<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormReceived extends Mailable
{
    use Queueable, SerializesModels;

    const SUBJECT = '[CONTACTO] Nuevo mensaje';

    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $formMessage;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email
     * @param string $formMessage
     */
    public function __construct(string $name, string $email, string $formMessage)
    {
        $this->name = $name;
        $this->email = $email;
        $this->formMessage = $formMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.contact-form.new-message')
            ->subject(self::SUBJECT);
    }
}
