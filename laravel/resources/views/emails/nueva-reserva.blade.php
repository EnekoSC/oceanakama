<x-mail::message>
# {{ __('Nueva reserva recibida') }}

{{ __('Se ha recibido una nueva reserva con los siguientes datos:') }}

<x-mail::table>
| | |
|:--|:--|
| **{{ __('Usuario') }}** | {{ $reserva->user->name }} ({{ $reserva->user->email }}) |
| **{{ __('Curso') }}** | {{ $reserva->curso->nombre }} |
| **{{ __('Fecha') }}** | {{ $reserva->curso->fecha_inicio?->translatedFormat('d M Y') }} — {{ $reserva->curso->fecha_fin?->translatedFormat('d M Y') }} |
| **{{ __('Nivel') }}** | {{ $reserva->curso->nivel->label() }} |
| **{{ __('Plazas restantes') }}** | {{ $reserva->curso->plazas_disponibles }} / {{ $reserva->curso->plazas_max }} |
</x-mail::table>

<x-mail::button :url="url('/admin/reservas/' . $reserva->id . '/edit')">
{{ __('Ver reserva en admin') }}
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
