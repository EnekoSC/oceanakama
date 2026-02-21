<article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition group">
    <a href="{{ route('cursos.show', $curso->slug) }}">
        @if($curso->imagen_url)
            <img src="{{ Storage::url($curso->imagen_url) }}" alt="{{ $curso->nombre }}"
                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300" loading="lazy">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-cyan-600 to-cyan-800 flex items-center justify-center">
                <svg class="w-16 h-16 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
            </div>
        @endif
    </a>
    <div class="p-5">
        <div class="flex items-center gap-2 mb-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                <span class="text-xs text-gray-500">{{ $curso->certificacion_ssi }}</span>
            @endif
        </div>
        <h3 class="font-semibold text-gray-900 mb-1">
            <a href="{{ route('cursos.show', $curso->slug) }}" class="hover:text-cyan-700 transition">
                {{ $curso->nombre }}
            </a>
        </h3>
        <div class="flex items-center text-sm text-gray-500 mb-3 space-x-3">
            @if($curso->fecha_inicio)
                <span>{{ $curso->fecha_inicio->format('d/m/Y') }}</span>
            @endif
            @if($curso->duracion)
                <span>&middot; {{ $curso->duracion }}</span>
            @endif
        </div>
        <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-cyan-700">{{ number_format($curso->precio, 2, ',', '.') }} &euro;</span>
            <span class="text-sm {{ $curso->tieneDisponibilidad() ? 'text-green-600' : 'text-red-600' }}">
                {{ $curso->tieneDisponibilidad() ? $curso->plazas_disponibles . ' ' . __('plazas') : __('Completo') }}
            </span>
        </div>
    </div>
</article>
