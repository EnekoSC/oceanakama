<?php

namespace App\Listeners;

use App\Mail\BienvenidaMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendBienvenidaEmail
{
    public function handle(Registered $event): void
    {
        Mail::to($event->user)->send(new BienvenidaMail($event->user));
    }
}
