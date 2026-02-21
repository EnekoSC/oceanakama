<x-mail::message>
# {{ __('Nuevo mensaje de contacto') }}

**{{ __('Nombre') }}:** {{ $datos['nombre'] }}

**{{ __('Email') }}:** {{ $datos['email'] }}

**{{ __('Asunto') }}:** {{ $datos['asunto'] }}

---

{{ $datos['mensaje'] }}

<x-mail::button :url="'mailto:' . $datos['email']">
{{ __('Responder') }}
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
