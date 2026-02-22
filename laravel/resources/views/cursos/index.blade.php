<x-public-layout>
    <x-slot:title>{{ __('Cursos de buceo') }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Cursos de buceo') }}</h1>

        {{-- Filtros --}}
        <form method="GET" action="{{ lroute('cursos.index') }}" class="mb-8">
            <div class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Buscar') }}</label>
                    <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}"
                           placeholder="{{ __('Nombre del curso...') }}"
                           class="rounded-lg border-gray-300 shadow-sm text-sm focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div>
                    <label for="nivel" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Nivel') }}</label>
                    <select name="nivel" id="nivel" class="rounded-lg border-gray-300 shadow-sm text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        <option value="">{{ __('Todos') }}</option>
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel->value }}" {{ request('nivel') === $nivel->value ? 'selected' : '' }}>
                                {{ $nivel->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="precio_max" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Precio máx.') }}</label>
                    <input type="number" name="precio_max" id="precio_max" value="{{ request('precio_max') }}"
                           placeholder="€" min="0" step="50"
                           class="w-28 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 transition">
                        {{ __('Filtrar') }}
                    </button>
                    @if(request()->hasAny(['buscar', 'nivel', 'precio_max']))
                        <a href="{{ lroute('cursos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                            {{ __('Limpiar') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Listado --}}
        @if($cursos->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cursos as $curso)
                    @include('cursos._card', ['curso' => $curso])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $cursos->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                <p class="text-gray-500 text-lg">{{ __('No se encontraron cursos con esos filtros.') }}</p>
                <a href="{{ lroute('cursos.index') }}" class="text-cyan-700 font-medium hover:underline mt-2 inline-block">{{ __('Ver todos los cursos') }}</a>
            </div>
        @endif
    </div>
</x-public-layout>
