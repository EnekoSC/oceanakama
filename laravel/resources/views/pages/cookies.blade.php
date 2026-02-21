<x-public-layout>
    <x-slot:title>{{ __('Política de cookies') }}</x-slot:title>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 prose prose-cyan max-w-none">
        <h1>{{ __('Política de cookies') }}</h1>
        <p class="text-sm text-gray-500">{{ __('Última actualización') }}: 21/02/2026</p>

        <h2>1. {{ __('¿Qué son las cookies?') }}</h2>
        <p>{{ __('Las cookies son pequeños archivos de texto que se almacenan en tu navegador al visitar un sitio web. Sirven para recordar tus preferencias y mejorar tu experiencia de navegación.') }}</p>

        <h2>2. {{ __('Cookies que utilizamos') }}</h2>

        <table>
            <thead>
                <tr>
                    <th>{{ __('Cookie') }}</th>
                    <th>{{ __('Tipo') }}</th>
                    <th>{{ __('Finalidad') }}</th>
                    <th>{{ __('Duración') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>XSRF-TOKEN</td>
                    <td>{{ __('Técnica') }}</td>
                    <td>{{ __('Protección contra ataques CSRF') }}</td>
                    <td>{{ __('Sesión') }}</td>
                </tr>
                <tr>
                    <td>oceanakama_session</td>
                    <td>{{ __('Técnica') }}</td>
                    <td>{{ __('Identificación de sesión de usuario') }}</td>
                    <td>2h</td>
                </tr>
                <tr>
                    <td>remember_web_*</td>
                    <td>{{ __('Técnica') }}</td>
                    <td>{{ __('Mantener la sesión iniciada') }}</td>
                    <td>{{ __('5 años') }}</td>
                </tr>
                <tr>
                    <td>cookie_consent</td>
                    <td>{{ __('Técnica') }}</td>
                    <td>{{ __('Recordar tu elección sobre cookies') }}</td>
                    <td>{{ __('1 año') }}</td>
                </tr>
            </tbody>
        </table>

        <h2>3. {{ __('Cookies de terceros') }}</h2>
        <p>{{ __('Actualmente no utilizamos cookies de terceros con fines analíticos o publicitarios. Si en el futuro incorporamos servicios de análisis, actualizaremos esta política.') }}</p>

        <h2>4. {{ __('Gestión de cookies') }}</h2>
        <p>{{ __('Puedes configurar tu navegador para bloquear o eliminar cookies. Ten en cuenta que desactivar las cookies técnicas puede afectar al funcionamiento del sitio.') }}</p>
        <ul>
            <li><strong>Chrome:</strong> chrome://settings/cookies</li>
            <li><strong>Firefox:</strong> about:preferences#privacy</li>
            <li><strong>Safari:</strong> {{ __('Preferencias > Privacidad') }}</li>
        </ul>
    </div>
</x-public-layout>
