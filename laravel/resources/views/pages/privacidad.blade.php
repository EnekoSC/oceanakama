<x-public-layout>
    <x-slot:title>{{ __('Política de privacidad') }}</x-slot:title>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 prose prose-cyan max-w-none">
        <h1>{{ __('Política de privacidad') }}</h1>
        <p class="text-sm text-gray-500">{{ __('Última actualización') }}: 21/02/2026</p>

        <h2>1. {{ __('Responsable del tratamiento') }}</h2>
        <p>oceaNakama<br>
        {{ __('Email') }}: hola@oceanakama.com</p>

        <h2>2. {{ __('Datos que recopilamos') }}</h2>
        <ul>
            <li><strong>{{ __('Datos de registro') }}:</strong> {{ __('nombre, apellidos, email, teléfono, certificación de buceo, número de inmersiones, seguro de buceo e idioma preferido.') }}</li>
            <li><strong>{{ __('Datos de pago') }}:</strong> {{ __('procesados directamente por Stripe. No almacenamos datos de tarjetas de crédito en nuestros servidores.') }}</li>
            <li><strong>{{ __('Datos de navegación') }}:</strong> {{ __('cookies técnicas y de sesión necesarias para el funcionamiento del sitio.') }}</li>
        </ul>

        <h2>3. {{ __('Finalidad del tratamiento') }}</h2>
        <ul>
            <li>{{ __('Gestionar tu cuenta de usuario y reservas de cursos.') }}</li>
            <li>{{ __('Procesar pagos de forma segura a través de Stripe.') }}</li>
            <li>{{ __('Enviarte comunicaciones relacionadas con tus reservas.') }}</li>
            <li>{{ __('Responder a tus consultas a través del formulario de contacto.') }}</li>
        </ul>

        <h2>4. {{ __('Base legal') }}</h2>
        <p>{{ __('El tratamiento de tus datos se basa en:') }}</p>
        <ul>
            <li>{{ __('Ejecución del contrato (reserva de cursos).') }}</li>
            <li>{{ __('Consentimiento (formulario de contacto, reseñas).') }}</li>
            <li>{{ __('Interés legítimo (seguridad y mejora del servicio).') }}</li>
        </ul>

        <h2>5. {{ __('Conservación de datos') }}</h2>
        <p>{{ __('Conservamos tus datos mientras mantengas tu cuenta activa. Puedes solicitar la eliminación de tu cuenta en cualquier momento desde tu perfil.') }}</p>

        <h2>6. {{ __('Derechos del usuario') }}</h2>
        <p>{{ __('Puedes ejercer tus derechos de acceso, rectificación, supresión, portabilidad, limitación y oposición contactándonos en hola@oceanakama.com.') }}</p>

        <h2>7. {{ __('Compartición de datos') }}</h2>
        <p>{{ __('Solo compartimos datos con:') }}</p>
        <ul>
            <li><strong>Stripe:</strong> {{ __('para el procesamiento de pagos.') }}</li>
        </ul>

        <h2>8. {{ __('Seguridad') }}</h2>
        <p>{{ __('Aplicamos medidas técnicas y organizativas para proteger tus datos: cifrado HTTPS, contraseñas hasheadas, acceso restringido.') }}</p>
    </div>
</x-public-layout>
