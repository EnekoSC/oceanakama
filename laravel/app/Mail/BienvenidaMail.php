<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BienvenidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Bienvenido a oceaNakama'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bienvenida',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
