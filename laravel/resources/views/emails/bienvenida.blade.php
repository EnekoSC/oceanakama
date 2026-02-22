<x-mail::message>
# {{ __('¡Bienvenido, :name!', ['name' => $user->name]) }}

{{ __('Gracias por registrarte en oceaNakama. Estamos encantados de tenerte a bordo.') }}

{{ __('Con tu cuenta puedes:') }}

- {{ __('Reservar cursos de buceo certificados SSI.') }}
- {{ __('Gestionar tus reservas desde tu panel.') }}
- {{ __('Dejar reseñas de los cursos que completes.') }}

<x-mail::button :url="lroute('cursos.index')">
{{ __('Explorar cursos') }}
</x-mail::button>

{{ __('¡Nos vemos bajo el agua!') }}<br>
{{ config('app.name') }}
</x-mail::message>
