<x-public-layout>
    <x-slot:title>{{ __('Inicio') }}</x-slot:title>

    {{-- Hero --}}
    <section class="relative bg-cyan-900 text-white overflow-hidden">
        <img src="{{ asset('images/portada.jpg') }}" alt="{{ __('Buceo') }}"
             class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 lg:py-40">
            <div class="max-w-2xl">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6 drop-shadow-lg">
                    {{ __('Descubre el mundo submarino') }}
                </h1>
                <p class="text-lg text-cyan-100 mb-8 drop-shadow">
                    {{ __('Cursos de buceo certificados SSI para todos los niveles. Aprende con profesionales y vive la aventura del mar.') }}
                </p>
                <a href="{{ route('cursos.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-white text-cyan-800 font-semibold rounded-lg hover:bg-cyan-50 transition shadow-lg">
                    {{ __('Ver cursos') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Cursos destacados --}}
    @if($cursosDestacados->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('Próximos cursos') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cursosDestacados as $curso)
                @include('cursos._card', ['curso' => $curso])
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('cursos.index') }}" class="text-cyan-700 font-semibold hover:underline">
                {{ __('Ver todos los cursos') }} &rarr;
            </a>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('¿Tienes dudas?') }}</h2>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto">
                {{ __('Contáctanos por WhatsApp o escríbenos un mensaje. Estaremos encantados de ayudarte a elegir el curso perfecto.') }}
            </p>
            <a href="{{ route('contacto') }}"
               class="inline-flex items-center px-6 py-3 bg-cyan-700 text-white font-semibold rounded-lg hover:bg-cyan-800 transition">
                {{ __('Contactar') }}
            </a>
        </div>
    </section>
</x-public-layout>
