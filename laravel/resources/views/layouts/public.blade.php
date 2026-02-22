<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' . config('app.name') : config('app.name') }}</title>
        <meta name="description" content="{{ $metaDescription ?? __('Cursos de buceo certificados SSI. Formación, aventura y pasión por el mar.') }}">

        <link rel="alternate" hreflang="es" href="{{ switchLocaleUrl('es') }}">
        <link rel="alternate" hreflang="en" href="{{ switchLocaleUrl('en') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        {{-- Navegación --}}
        <nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Izquierda: Logo --}}
                    <div class="flex-shrink-0">
                        <a href="{{ lroute('home') }}" class="text-xl font-bold text-cyan-700">
                            oceaNakama
                        </a>
                    </div>

                    {{-- Centro: Navegación principal --}}
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="{{ lroute('home') }}"
                           class="text-sm font-medium {{ request()->routeIs('*.home') ? 'text-cyan-700' : 'text-gray-600 hover:text-cyan-700' }} transition">
                            {{ __('Inicio') }}
                        </a>
                        <a href="{{ lroute('cursos.index') }}"
                           class="text-sm font-medium {{ request()->routeIs('*.cursos.*') ? 'text-cyan-700' : 'text-gray-600 hover:text-cyan-700' }} transition">
                            {{ __('Cursos') }}
                        </a>
                        <a href="{{ lroute('contacto') }}"
                           class="text-sm font-medium {{ request()->routeIs('*.contacto') ? 'text-cyan-700' : 'text-gray-600 hover:text-cyan-700' }} transition">
                            {{ __('Contacto') }}
                        </a>
                    </div>

                    {{-- Derecha: Mi cuenta + Idioma --}}
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        @auth
                            <a href="{{ lroute('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-cyan-700 transition">
                                {{ __('Mi cuenta') }}
                            </a>
                        @else
                            <button @click="$dispatch('open-login-modal')" class="text-sm font-medium text-gray-600 hover:text-cyan-700 transition cursor-pointer">
                                {{ __('Entrar') }}
                            </button>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 transition">
                                {{ __('Registro') }}
                            </a>
                        @endauth

                        <span class="w-px h-5 bg-gray-200"></span>

                        {{-- Selector de idioma --}}
                        <div x-data="{ langOpen: false }" class="relative">
                            <button @click="langOpen = !langOpen" class="text-sm text-gray-500 hover:text-cyan-700 transition">
                                {{ strtoupper(app()->getLocale()) }}
                                <svg class="inline w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="langOpen" @click.away="langOpen = false" x-transition
                                 class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg border">
                                <a href="{{ switchLocaleUrl('es') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">ES</a>
                                <a href="{{ switchLocaleUrl('en') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">EN</a>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile hamburger --}}
                    <div class="flex items-center sm:hidden">
                        <button @click="open = !open" class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t">
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ lroute('home') }}" class="block text-sm font-medium {{ request()->routeIs('*.home') ? 'text-cyan-700' : 'text-gray-700' }} py-1">{{ __('Inicio') }}</a>
                    <a href="{{ lroute('cursos.index') }}" class="block text-sm font-medium {{ request()->routeIs('*.cursos.*') ? 'text-cyan-700' : 'text-gray-700' }} py-1">{{ __('Cursos') }}</a>
                    <a href="{{ lroute('contacto') }}" class="block text-sm font-medium {{ request()->routeIs('*.contacto') ? 'text-cyan-700' : 'text-gray-700' }} py-1">{{ __('Contacto') }}</a>
                    <div class="pt-2 border-t space-y-2">
                        @auth
                            <a href="{{ lroute('dashboard') }}" class="block text-sm font-medium text-cyan-700 py-1">{{ __('Mi cuenta') }}</a>
                        @else
                            <button @click="open = false; $dispatch('open-login-modal')" class="block text-sm font-medium text-gray-700 py-1 text-left cursor-pointer">{{ __('Entrar') }}</button>
                            <a href="{{ route('register') }}" class="block text-sm font-medium text-cyan-700 py-1">{{ __('Registro') }}</a>
                        @endauth
                    </div>
                    <div class="flex space-x-3 pt-2 border-t">
                        <a href="{{ switchLocaleUrl('es') }}" class="text-sm {{ app()->getLocale() === 'es' ? 'text-cyan-700 font-medium' : 'text-gray-500' }}">ES</a>
                        <a href="{{ switchLocaleUrl('en') }}" class="text-sm {{ app()->getLocale() === 'en' ? 'text-cyan-700 font-medium' : 'text-gray-500' }}">EN</a>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Contenido --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-gray-900 text-gray-400 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-white font-bold text-lg mb-3">oceaNakama</h3>
                        <p class="text-sm">{{ __('Cursos de buceo certificados SSI. Formación, aventura y pasión por el mar.') }}</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-3">{{ __('Enlaces') }}</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ lroute('cursos.index') }}" class="hover:text-white transition">{{ __('Cursos') }}</a></li>
                            <li><a href="{{ lroute('contacto') }}" class="hover:text-white transition">{{ __('Contacto') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-3">{{ __('Legal') }}</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ lroute('privacidad') }}" class="hover:text-white transition">{{ __('Política de privacidad') }}</a></li>
                            <li><a href="{{ lroute('terminos') }}" class="hover:text-white transition">{{ __('Términos y condiciones') }}</a></li>
                            <li><a href="{{ lroute('cookies') }}" class="hover:text-white transition">{{ __('Cookies') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                    <p>&copy; {{ date('Y') }} oceaNakama. {{ __('Todos los derechos reservados.') }}</p>
                </div>
            </div>
        </footer>

        {{-- Banner de cookies --}}
        <div x-data="{ show: !document.cookie.includes('cookie_consent=') }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-0 inset-x-0 z-50 p-4"
             style="display: none;">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg border p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <p class="text-sm text-gray-600 flex-1">
                    {{ __('Utilizamos cookies técnicas necesarias para el funcionamiento del sitio.') }}
                    <a href="{{ lroute('cookies') }}" class="text-cyan-700 underline hover:text-cyan-800">{{ __('Más información') }}</a>
                </p>
                <div class="flex gap-2 flex-shrink-0">
                    <button @click="document.cookie = 'cookie_consent=accepted; path=/; max-age=31536000; SameSite=Lax'; show = false"
                            class="px-4 py-2 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 transition">
                        {{ __('Aceptar') }}
                    </button>
                    <button @click="document.cookie = 'cookie_consent=rejected; path=/; max-age=31536000; SameSite=Lax'; show = false"
                            class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                        {{ __('Rechazar') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal Login --}}
        @guest
        <div x-data="{ showLogin: {{ $errors->has('email') || $errors->has('password') ? 'true' : 'false' }} }"
             @open-login-modal.window="showLogin = true"
             @keydown.escape.window="showLogin = false">

            {{-- Overlay --}}
            <div x-show="showLogin"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showLogin = false"
                 class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm"
                 style="display: none;"></div>

            {{-- Panel --}}
            <div x-show="showLogin"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="fixed inset-0 z-[70] flex items-center justify-center p-4"
                 style="display: none;">
                <div @click.stop class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 relative">
                    {{-- Cerrar --}}
                    <button @click="showLogin = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    {{-- Logo --}}
                    <div class="text-center mb-6">
                        <a href="{{ lroute('home') }}" class="text-2xl font-bold text-cyan-700">oceaNakama</a>
                    </div>

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="modal_email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input id="modal_email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="modal_password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="modal_password" type="password" name="password" required
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-cyan-700 shadow-sm focus:ring-cyan-500">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-cyan-700 hover:text-cyan-800 transition">
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition">
                            {{ __('Log in') }}
                        </button>

                        <p class="text-center text-sm text-gray-600">
                            {{ __('¿No tienes cuenta?') }}
                            <a href="{{ route('register') }}" class="text-cyan-700 font-medium hover:text-cyan-800 transition">
                                {{ __('Registro') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        @endguest

        {{-- Botón WhatsApp --}}
        <a href="https://wa.me/34600000000" target="_blank" rel="noopener"
           class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition z-50"
           aria-label="WhatsApp">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
    </body>
</html>
