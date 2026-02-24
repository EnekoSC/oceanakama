<x-public-layout>
    <x-slot:title>{{ $curso->nombre }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <nav class="mb-6 text-sm text-gray-500">
            <a href="{{ lroute('cursos.index') }}" class="hover:text-cyan-700">{{ __('Cursos') }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $curso->nombre }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Columna principal --}}
            <div class="lg:col-span-2">
                @if($curso->imagen_url)
                    <img src="{{ Storage::url($curso->imagen_url) }}" alt="{{ $curso->nombre }}"
                         class="w-full h-72 lg:h-96 object-cover rounded-xl mb-6" loading="lazy">
                @else
                    <div class="w-full h-72 lg:h-96 bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl mb-6 flex items-center justify-center">
                        <svg class="w-24 h-24 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
                    </div>
                @endif

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $curso->nombre }}</h1>

                <div class="flex flex-wrap gap-3 mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ match($curso->nivel->value) {
                            'principiante' => 'bg-green-100 text-green-800',
                            'intermedio' => 'bg-blue-100 text-blue-800',
                            'avanzado' => 'bg-amber-100 text-amber-800',
                            'profesional' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        } }}">
                        {{ $curso->nivel->label() }}
                    </span>
                    @if($curso->certificacion_ssi)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            SSI: {{ $curso->certificacion_ssi }}
                        </span>
                    @endif
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-50 text-cyan-800">
                        {{ $curso->estado->label() }}
                    </span>
                </div>

                @if($curso->descripcion)
                    <div class="prose prose-cyan max-w-none mb-10">
                        {!! $curso->descripcion !!}
                    </div>
                @endif

                {{-- Reseñas --}}
                @if($curso->resenas->isNotEmpty())
                    <section class="border-t pt-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('Reseñas') }}</h2>
                        <div class="space-y-6">
                            @foreach($curso->resenas as $resena)
                                <div class="bg-white rounded-lg p-5 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-medium text-gray-900">{{ $resena->user->name }}</span>
                                        <span class="text-amber-500 text-sm">
                                            {{ str_repeat('★', $resena->puntuacion) }}{{ str_repeat('☆', 5 - $resena->puntuacion) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ $resena->texto }}</p>
                                    <span class="text-xs text-gray-400 mt-2 block">{{ $resena->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <div class="text-3xl font-bold text-cyan-700 mb-4">
                        {{ number_format($curso->precio, 2, ',', '.') }} &euro;
                    </div>

                    <dl class="space-y-3 text-sm mb-6">
                        @if($curso->fecha_inicio)
                            <div class="flex justify-between">
                                <dt class="text-gray-500">{{ __('Fecha inicio') }}</dt>
                                <dd class="font-medium">{{ $curso->fecha_inicio->format('d/m/Y') }}</dd>
                            </div>
                        @endif
                        @if($curso->fecha_fin)
                            <div class="flex justify-between">
                                <dt class="text-gray-500">{{ __('Fecha fin') }}</dt>
                                <dd class="font-medium">{{ $curso->fecha_fin->format('d/m/Y') }}</dd>
                            </div>
                        @endif
                        @if($curso->duracion)
                            <div class="flex justify-between">
                                <dt class="text-gray-500">{{ __('Duración') }}</dt>
                                <dd class="font-medium">{{ $curso->duracion }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <dt class="text-gray-500">{{ __('Plazas disponibles') }}</dt>
                            <dd class="font-medium {{ $curso->tieneDisponibilidad() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $curso->plazas_disponibles }} / {{ $curso->plazas_max }}
                            </dd>
                        </div>
                    </dl>

                    @if(session('success'))
                        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 text-sm font-medium">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $reservaActiva = auth()->check()
                            ? $curso->reservas()->where('user_id', auth()->id())
                                ->whereIn('estado', [\App\Enums\EstadoReserva::Pendiente, \App\Enums\EstadoReserva::PendientePago, \App\Enums\EstadoReserva::Confirmada])
                                ->first()
                            : null;
                    @endphp

                    @if($reservaActiva)
                        @php
                            $badgeClasses = match($reservaActiva->estado) {
                                \App\Enums\EstadoReserva::Pendiente => 'bg-blue-100 text-blue-800',
                                \App\Enums\EstadoReserva::PendientePago => 'bg-yellow-100 text-yellow-800',
                                \App\Enums\EstadoReserva::Confirmada => 'bg-green-100 text-green-800',
                            };
                        @endphp
                        <div class="text-center py-3 rounded-lg {{ $badgeClasses }} font-medium">
                            {{ $reservaActiva->estado->label() }}
                        </div>
                    @elseif($curso->tieneDisponibilidad() && $curso->estado === \App\Enums\EstadoCurso::Proximo)
                        @auth
                            <form action="{{ lroute('cursos.reservar', $curso->slug) }}" method="POST">
                                @csrf
                                <button type="submit"
                                   class="block w-full text-center px-6 py-3 bg-cyan-700 text-white font-semibold rounded-lg hover:bg-cyan-800 transition cursor-pointer">
                                    {{ __('Reservar plaza') }}
                                </button>
                            </form>
                        @else
                            <button x-data @click="$dispatch('open-login-modal')"
                               class="block w-full text-center px-6 py-3 bg-cyan-700 text-white font-semibold rounded-lg hover:bg-cyan-800 transition cursor-pointer">
                                {{ __('Inicia sesión para reservar') }}
                            </button>
                        @endauth
                    @elseif(!$curso->tieneDisponibilidad())
                        <div class="text-center py-3 bg-gray-100 rounded-lg text-gray-500 font-medium">
                            {{ __('Sin plazas disponibles') }}
                        </div>
                    @endif

                    <a href="https://wa.me/34600000000?text={{ urlencode(__('Hola, me interesa el curso: ') . $curso->nombre) }}"
                       target="_blank" rel="noopener"
                       class="mt-3 block w-full text-center px-6 py-3 border border-green-500 text-green-600 font-semibold rounded-lg hover:bg-green-50 transition">
                        {{ __('Preguntar por WhatsApp') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
