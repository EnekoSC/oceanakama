<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' . config('app.name') : config('app.name') }}</title>
        <meta name="description" content="{{ $metaDescription ?? __('Cursos de buceo certificados SSI. Formación, aventura y pasión por el mar.') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        {{-- Navegación --}}
        <nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    {{-- Logo --}}
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-cyan-700">
                            oceaNakama
                        </a>
                    </div>

                    {{-- Desktop Nav --}}
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="{{ route('home') }}"
                           class="text-sm font-medium {{ request()->routeIs('home') ? 'text-cyan-700' : 'text-gray-600 hover:text-cyan-700' }} transition">
                            {{ __('Inicio') }}
                        </a>
                        <a href="{{ route('cursos.index') }}"
                           class="text-sm font-medium {{ request()->routeIs('cursos.*') ? 'text-cyan-700' : 'text-gray-600 hover:text-cyan-700' }} transition">
                            {{ __('Cursos') }}
                        </a>
                        <a href="{{ route('contacto') }}"
                           class="text-sm font-medium {{ request()->routeIs('contacto') ? 'text-cyan-700' : 'text-gray-600 hover:text-cyan-700' }} transition">
                            {{ __('Contacto') }}
                        </a>

                        {{-- Selector de idioma --}}
                        <div x-data="{ langOpen: false }" class="relative">
                            <button @click="langOpen = !langOpen" class="text-sm text-gray-500 hover:text-cyan-700 transition">
                                {{ strtoupper(app()->getLocale()) }}
                                <svg class="inline w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="langOpen" @click.away="langOpen = false" x-transition
                                 class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg border">
                                <a href="{{ route('lang.switch', 'es') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">ES</a>
                                <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">EN</a>
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-cyan-700 transition">
                                {{ __('Mi cuenta') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-cyan-700 transition">
                                {{ __('Entrar') }}
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 transition">
                                {{ __('Registro') }}
                            </a>
                        @endauth
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
                    <a href="{{ route('home') }}" class="block text-sm font-medium text-gray-700 py-1">{{ __('Inicio') }}</a>
                    <a href="{{ route('cursos.index') }}" class="block text-sm font-medium text-gray-700 py-1">{{ __('Cursos') }}</a>
                    <a href="{{ route('contacto') }}" class="block text-sm font-medium text-gray-700 py-1">{{ __('Contacto') }}</a>
                    <div class="flex space-x-3 pt-2 border-t">
                        <a href="{{ route('lang.switch', 'es') }}" class="text-sm text-gray-500">ES</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="text-sm text-gray-500">EN</a>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-sm font-medium text-cyan-700 py-1">{{ __('Mi cuenta') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-sm font-medium text-gray-700 py-1">{{ __('Entrar') }}</a>
                        <a href="{{ route('register') }}" class="block text-sm font-medium text-cyan-700 py-1">{{ __('Registro') }}</a>
                    @endauth
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
                            <li><a href="{{ route('cursos.index') }}" class="hover:text-white transition">{{ __('Cursos') }}</a></li>
                            <li><a href="{{ route('contacto') }}" class="hover:text-white transition">{{ __('Contacto') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-3">{{ __('Legal') }}</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">{{ __('Política de privacidad') }}</a></li>
                            <li><a href="#" class="hover:text-white transition">{{ __('Términos y condiciones') }}</a></li>
                            <li><a href="#" class="hover:text-white transition">{{ __('Cookies') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                    <p>&copy; {{ date('Y') }} oceaNakama. {{ __('Todos los derechos reservados.') }}</p>
                </div>
            </div>
        </footer>

        {{-- Botón WhatsApp --}}
        <a href="https://wa.me/34600000000" target="_blank" rel="noopener"
           class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition z-50"
           aria-label="WhatsApp">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
    </body>
</html>
