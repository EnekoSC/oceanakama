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
        <link rel="alternate" hreflang="fr" href="{{ switchLocaleUrl('fr') }}">

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
                            <button @click="$dispatch('open-register-modal')" class="inline-flex items-center px-4 py-2 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 transition cursor-pointer">
                                {{ __('Registro') }}
                            </button>
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
                                <a href="{{ switchLocaleUrl('fr') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">FR</a>
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
                            <button @click="open = false; $dispatch('open-register-modal')" class="block text-sm font-medium text-cyan-700 py-1 text-left cursor-pointer">{{ __('Registro') }}</button>
                        @endauth
                    </div>
                    <div class="flex space-x-3 pt-2 border-t">
                        <a href="{{ switchLocaleUrl('es') }}" class="text-sm {{ app()->getLocale() === 'es' ? 'text-cyan-700 font-medium' : 'text-gray-500' }}">ES</a>
                        <a href="{{ switchLocaleUrl('en') }}" class="text-sm {{ app()->getLocale() === 'en' ? 'text-cyan-700 font-medium' : 'text-gray-500' }}">EN</a>
                        <a href="{{ switchLocaleUrl('fr') }}" class="text-sm {{ app()->getLocale() === 'fr' ? 'text-cyan-700 font-medium' : 'text-gray-500' }}">FR</a>
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
                @php $social = app(\App\Settings\SocialSettings::class); $hasSocial = $social->linkedin_url || $social->youtube_url || $social->instagram_url || $social->tiktok_url; @endphp
                <div class="grid grid-cols-1 {{ $hasSocial ? 'md:grid-cols-4' : 'md:grid-cols-3' }} gap-8">
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
                    @if($hasSocial)
                    <div>
                        <h4 class="text-white font-semibold mb-3">{{ __('Síguenos') }}</h4>
                        <ul class="space-y-2 text-sm">
                            @if($social->linkedin_url)
                            <li>
                                <a href="{{ $social->linkedin_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    LinkedIn
                                </a>
                            </li>
                            @endif
                            @if($social->youtube_url)
                            <li>
                                <a href="{{ $social->youtube_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    YouTube
                                </a>
                            </li>
                            @endif
                            @if($social->instagram_url)
                            <li>
                                <a href="{{ $social->instagram_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    Instagram
                                </a>
                            </li>
                            @endif
                            @if($social->tiktok_url)
                            <li>
                                <a href="{{ $social->tiktok_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                    TikTok
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm space-y-1">
                    <p>&copy; {{ date('Y') }} oceaNakama. {{ __('Todos los derechos reservados.') }}</p>
                    <p>Designed with <svg class="inline-block w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/></svg> by Eneko</p>
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

        {{-- Modales Auth --}}
        @guest
        <div x-data="{ modal: '{{ old('_modal', session('_modal', '')) ?: ($errors->has('name') || $errors->has('password_confirmation') ? 'register' : ($errors->any() ? 'login' : '')) }}' }"
             @open-login-modal.window="modal = 'login'"
             @open-register-modal.window="modal = 'register'"
             @open-forgot-modal.window="modal = 'forgot'"
             @keydown.escape.window="modal = ''">

            {{-- Overlay --}}
            <template x-if="modal !== ''">
                <div x-show="modal !== ''"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="modal = ''"
                     class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm"></div>
            </template>

            {{-- Modal Login --}}
            <div x-show="modal === 'login'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="fixed inset-0 z-[70] flex items-center justify-center p-4"
                 style="display: none;">
                <div @click.stop class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 relative">
                    <button @click="modal = ''" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="text-center mb-6">
                        <span class="text-2xl font-bold text-cyan-700">oceaNakama</span>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_modal" value="login">

                        <div>
                            <label for="login_email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input id="login_email" type="email" name="email" value="{{ old('email') }}" required
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="login_password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="login_password" type="password" name="password" required
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
                            <button type="button" @click="modal = 'forgot'" class="text-sm text-cyan-700 hover:text-cyan-800 transition">
                                {{ __('Forgot your password?') }}
                            </button>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition">
                            {{ __('Log in') }}
                        </button>

                        <p class="text-center text-sm text-gray-600">
                            {{ __('¿No tienes cuenta?') }}
                            <button type="button" @click="modal = 'register'" class="text-cyan-700 font-medium hover:text-cyan-800 transition">
                                {{ __('Registro') }}
                            </button>
                        </p>
                    </form>
                </div>
            </div>

            {{-- Modal Registro --}}
            <div x-show="modal === 'register'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="fixed inset-0 z-[70] flex items-center justify-center p-4"
                 style="display: none;">
                <div @click.stop class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 relative">
                    <button @click="modal = ''" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="text-center mb-6">
                        <span class="text-2xl font-bold text-cyan-700">oceaNakama</span>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_modal" value="register">

                        <div>
                            <label for="register_name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                            <input id="register_name" type="text" name="name" value="{{ old('name') }}" required
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register_email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input id="register_email" type="email" name="email" value="{{ old('email') }}" required
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register_password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="register_password" type="password" name="password" required
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                            <input id="register_password_confirmation" type="password" name="password_confirmation" required
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition">
                            {{ __('Register') }}
                        </button>

                        <p class="text-center text-sm text-gray-600">
                            {{ __('¿Ya tienes cuenta?') }}
                            <button type="button" @click="modal = 'login'" class="text-cyan-700 font-medium hover:text-cyan-800 transition">
                                {{ __('Entrar') }}
                            </button>
                        </p>
                    </form>
                </div>
            </div>
            {{-- Modal Recuperar contraseña --}}
            <div x-show="modal === 'forgot'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="fixed inset-0 z-[70] flex items-center justify-center p-4"
                 style="display: none;">
                <div @click.stop class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 relative">
                    <button @click="modal = ''" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="text-center mb-6">
                        <span class="text-2xl font-bold text-cyan-700">oceaNakama</span>
                    </div>

                    <p class="text-sm text-gray-600 mb-5">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>

                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_modal" value="forgot">

                        <div>
                            <label for="forgot_email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input id="forgot_email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="block mt-1 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition">
                            {{ __('Email Password Reset Link') }}
                        </button>

                        <p class="text-center text-sm text-gray-600">
                            <button type="button" @click="modal = 'login'" class="text-cyan-700 font-medium hover:text-cyan-800 transition">
                                {{ __('Volver al inicio de sesión') }}
                            </button>
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
