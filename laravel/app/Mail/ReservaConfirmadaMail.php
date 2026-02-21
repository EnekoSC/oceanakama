<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaConfirmadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Reserva $reserva,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Reserva confirmada — :curso', ['curso' => $this->reserva->curso->nombre]),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reserva-confirmada',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
