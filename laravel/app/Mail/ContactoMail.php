<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $datos,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [$this->datos['email']],
            subject: '[oceaNakama] ' . $this->datos['asunto'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contacto',
            with: ['datos' => $this->datos],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
