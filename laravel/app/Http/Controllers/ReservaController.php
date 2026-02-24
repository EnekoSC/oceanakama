<?php

namespace App\Http\Controllers;

use App\Enums\EstadoCurso;
use App\Enums\EstadoReserva;
use App\Mail\NuevaReservaMail;
use App\Models\Curso;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{
    public function store(Curso $curso)
    {
        $user = auth()->user();

        // Check if user already has an active reservation for this course
        $existingReserva = Reserva::where('user_id', $user->id)
            ->where('curso_id', $curso->id)
            ->first();

        if ($existingReserva && in_array($existingReserva->estado, [EstadoReserva::Pendiente, EstadoReserva::PendientePago, EstadoReserva::Confirmada])) {
            return back()->with('error', __('Ya tienes una reserva activa para este curso.'));
        }

        if ($curso->estado !== EstadoCurso::Proximo) {
            return back()->with('error', __('Este curso no está disponible para reservas.'));
        }

        $reserva = DB::transaction(function () use ($curso, $user, $existingReserva) {
            $curso = Curso::lockForUpdate()->find($curso->id);

            if (! $curso->tieneDisponibilidad()) {
                return null;
            }

            $curso->decrement('plazas_disponibles');

            if ($existingReserva && $existingReserva->estado === EstadoReserva::Cancelada) {
                $existingReserva->update(['estado' => EstadoReserva::Pendiente]);

                return $existingReserva->fresh();
            }

            return Reserva::create([
                'user_id' => $user->id,
                'curso_id' => $curso->id,
                'estado' => EstadoReserva::Pendiente,
            ]);
        });

        if (! $reserva) {
            return back()->with('error', __('Lo sentimos, no quedan plazas disponibles.'));
        }

        $reserva->loadMissing(['user', 'curso']);
        Mail::to(config('mail.from.address'))->send(new NuevaReservaMail($reserva));

        return back()->with('success', __('Tu reserva se ha registrado correctamente. Recibirás un email cuando sea confirmada.'));
    }
}
