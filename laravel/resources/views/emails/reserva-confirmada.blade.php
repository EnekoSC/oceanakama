<x-mail::message>
# {{ __('¡Reserva confirmada!') }}

{{ __('Hola, :name. Tu reserva ha sido confirmada.', ['name' => $reserva->user->name]) }}

<x-mail::table>
| | |
|:--|:--|
| **{{ __('Curso') }}** | {{ $reserva->curso->nombre }} |
| **{{ __('Fecha') }}** | {{ $reserva->curso->fecha_inicio?->translatedFormat('d M Y') }} — {{ $reserva->curso->fecha_fin?->translatedFormat('d M Y') }} |
| **{{ __('Nivel') }}** | {{ $reserva->curso->nivel->label() }} |
| **{{ __('Duración') }}** | {{ $reserva->curso->duracion }} |
| **{{ __('Precio pagado') }}** | {{ number_format($reserva->precio_pagado, 2, ',', '.') }} &euro; |
</x-mail::table>

{{ __('Si tienes alguna pregunta, no dudes en contactarnos.') }}

<x-mail::button :url="lroute('dashboard')">
{{ __('Ver mis reservas') }}
</x-mail::button>

{{ __('¡Nos vemos bajo el agua!') }}<br>
{{ config('app.name') }}
</x-mail::message>
