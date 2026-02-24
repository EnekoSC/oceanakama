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
        if (! $reserva->wasChanged('estado')) {
            return;
        }

        $reserva->loadMissing(['user', 'curso']);

        if ($reserva->estado === EstadoReserva::Confirmada) {
            Mail::to($reserva->user)->send(new ReservaConfirmadaMail($reserva));
        }

        $previousEstado = $reserva->getOriginal('estado');

        if ($reserva->estado === EstadoReserva::Cancelada
            && in_array($previousEstado, [EstadoReserva::Pendiente, EstadoReserva::PendientePago, EstadoReserva::Confirmada])) {
            $reserva->curso->increment('plazas_disponibles');
        }
    }
}
