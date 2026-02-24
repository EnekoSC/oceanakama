<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaReservaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Reserva $reserva,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('[oceaNakama] Nueva reserva — :curso', ['curso' => $this->reserva->curso->nombre]),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.nueva-reserva',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
