<?php

namespace App\Observers;

use App\Enums\EstadoReserva;
use App\Mail\ReservaConfirmadaMail;
use App\Models\Reserva;
use Illuminate\Support\Facades\Mail;

class ReservaObserver
{
    public function updated(Reserva $reserva): void
    {
        if ($reserva->wasChanged('estado') && $reserva->estado === EstadoReserva::Confirmada) {
            $reserva->loadMissing(['user', 'curso']);
            Mail::to($reserva->user)->send(new ReservaConfirmadaMail($reserva));
        }
    }
}
