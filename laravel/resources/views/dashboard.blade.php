<x-public-layout>
    <x-slot:title>{{ __('Mi cuenta') }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Cabecera --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Hola, :name', ['name' => auth()->user()->name]) }}</h1>
                <p class="mt-1 text-gray-500">{{ auth()->user()->email }}</p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    {{ __('Editar perfil') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                        {{ __('Cerrar sesión') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Mis reservas --}}
        <section>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Mis reservas') }}</h2>

            @if ($reservas->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500 mb-4">{{ __('Aún no tienes ninguna reserva.') }}</p>
                    <a href="{{ route('cursos.index') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-cyan-700 text-white font-medium rounded-lg hover:bg-cyan-800 transition">
                        {{ __('Explorar cursos') }}
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($reservas as $reserva)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="flex flex-col sm:flex-row">
                                {{-- Imagen del curso --}}
                                <div class="sm:w-48 sm:flex-shrink-0">
                                    @if ($reserva->curso->imagen_url)
                                        <img src="{{ $reserva->curso->imagen_url }}" alt="{{ $reserva->curso->nombre }}"
                                             class="h-32 sm:h-full w-full object-cover">
                                    @else
                                        <div class="h-32 sm:h-full w-full bg-gradient-to-br from-cyan-100 to-cyan-200 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="font-semibold text-gray-900">
                                                <a href="{{ route('cursos.show', $reserva->curso->slug) }}" class="hover:text-cyan-700 transition">
                                                    {{ $reserva->curso->nombre }}
                                                </a>
                                            </h3>
                                            @php
                                                $badgeClasses = match($reserva->estado) {
                                                    \App\Enums\EstadoReserva::Confirmada => 'bg-green-100 text-green-800',
                                                    \App\Enums\EstadoReserva::PendientePago => 'bg-yellow-100 text-yellow-800',
                                                    \App\Enums\EstadoReserva::Cancelada => 'bg-red-100 text-red-800',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClasses }}">
                                                {{ $reserva->estado->label() }}
                                            </span>
                                        </div>

                                        <div class="text-sm text-gray-500 space-y-0.5">
                                            @if ($reserva->curso->fecha_inicio)
                                                <p>{{ $reserva->curso->fecha_inicio->translatedFormat('d M Y') }} — {{ $reserva->curso->fecha_fin->translatedFormat('d M Y') }}</p>
                                            @endif
                                            <p>{{ $reserva->curso->nivel->label() }} · {{ $reserva->curso->duracion }}</p>
                                        </div>

                                        @if ($reserva->precio_pagado)
                                            <p class="mt-1 text-sm font-medium text-gray-700">
                                                {{ __('Pagado') }}: {{ number_format($reserva->precio_pagado, 2, ',', '.') }} &euro;
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Acciones --}}
                                    <div class="flex flex-wrap gap-2 sm:flex-col sm:items-end">
                                        <a href="{{ route('cursos.show', $reserva->curso->slug) }}"
                                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100 transition">
                                            {{ __('Ver curso') }}
                                        </a>

                                        @if ($reserva->estado === \App\Enums\EstadoReserva::Confirmada
                                            && $reserva->curso->estado === \App\Enums\EstadoCurso::Completado
                                            && !in_array($reserva->curso_id, $resenasHechas))
                                            <a href="{{ route('cursos.show', $reserva->curso->slug) }}#resenas"
                                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-700 bg-amber-50 rounded-lg hover:bg-amber-100 transition">
                                                {{ __('Dejar reseña') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-public-layout>
