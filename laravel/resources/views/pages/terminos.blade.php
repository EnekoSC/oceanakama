<x-public-layout>
    <x-slot:title>{{ __('Términos y condiciones') }}</x-slot:title>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 prose prose-cyan max-w-none">
        <h1>{{ __('Términos y condiciones') }}</h1>
        <p class="text-sm text-gray-500">{{ __('Última actualización') }}: 21/02/2026</p>

        <h2>1. {{ __('Objeto') }}</h2>
        <p>{{ __('Estos términos regulan el uso del sitio web oceaNakama y la contratación de cursos de buceo a través de la plataforma.') }}</p>

        <h2>2. {{ __('Registro de usuario') }}</h2>
        <p>{{ __('Para reservar un curso es necesario crear una cuenta. El usuario se compromete a proporcionar información veraz y a mantener la confidencialidad de sus credenciales.') }}</p>

        <h2>3. {{ __('Reservas y pagos') }}</h2>
        <ul>
            <li>{{ __('La reserva se confirma una vez completado el pago íntegro del curso.') }}</li>
            <li>{{ __('Los pagos se procesan de forma segura a través de Stripe.') }}</li>
            <li>{{ __('Los precios incluyen IVA salvo que se indique lo contrario.') }}</li>
        </ul>

        <h2>4. {{ __('Cancelaciones') }}</h2>
        <ul>
            <li>{{ __('Cancelación con más de 14 días de antelación: reembolso completo.') }}</li>
            <li>{{ __('Cancelación entre 7 y 14 días: reembolso del 50%.') }}</li>
            <li>{{ __('Cancelación con menos de 7 días: sin reembolso.') }}</li>
            <li>{{ __('oceaNakama se reserva el derecho de cancelar un curso por causas de fuerza mayor, ofreciendo reembolso completo o cambio de fecha.') }}</li>
        </ul>

        <h2>5. {{ __('Requisitos de los cursos') }}</h2>
        <p>{{ __('El alumno debe cumplir los requisitos médicos y de certificación previos indicados en cada curso. oceaNakama podrá denegar la participación si no se cumplen estos requisitos.') }}</p>

        <h2>6. {{ __('Reseñas') }}</h2>
        <p>{{ __('Las reseñas deben ser honestas y respetuosas. oceaNakama se reserva el derecho de moderar y rechazar contenido inapropiado.') }}</p>

        <h2>7. {{ __('Propiedad intelectual') }}</h2>
        <p>{{ __('Todo el contenido del sitio (textos, imágenes, diseño) es propiedad de oceaNakama y no puede ser reproducido sin autorización.') }}</p>

        <h2>8. {{ __('Limitación de responsabilidad') }}</h2>
        <p>{{ __('oceaNakama no se hace responsable de daños derivados del uso incorrecto de la plataforma o de la práctica del buceo fuera de las actividades contratadas.') }}</p>

        <h2>9. {{ __('Legislación aplicable') }}</h2>
        <p>{{ __('Estos términos se rigen por la legislación española. Para cualquier controversia, las partes se someten a los juzgados y tribunales del domicilio del consumidor.') }}</p>
    </div>
</x-public-layout>
