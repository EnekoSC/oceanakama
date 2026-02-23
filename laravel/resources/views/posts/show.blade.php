<x-public-layout>
    <x-slot:title>{{ $post->titulo }}</x-slot:title>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <nav class="mb-6 text-sm text-gray-500">
            <a href="{{ lroute('blog.index') }}" class="hover:text-cyan-700">{{ __('Blog') }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $post->titulo }}</span>
        </nav>

        @if($post->imagen_url)
            <img src="{{ Storage::url($post->imagen_url) }}" alt="{{ $post->titulo }}"
                 class="w-full h-72 lg:h-96 object-cover rounded-xl mb-8" loading="lazy">
        @endif

        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $post->titulo }}</h1>

        <div class="flex items-center text-sm text-gray-500 mb-8 space-x-3">
            @if($post->published_at)
                <span>{{ __('Publicado el') }} {{ $post->published_at->format('d/m/Y') }}</span>
            @endif
            @if($post->autor)
                <span>&middot;</span>
                <span>{{ $post->autor->name }}</span>
            @endif
        </div>

        <div class="prose prose-cyan max-w-none">
            {!! $post->contenido !!}
        </div>

        <div class="mt-12 pt-8 border-t">
            <a href="{{ lroute('blog.index') }}" class="text-cyan-700 font-semibold hover:underline">
                &larr; {{ __('Blog') }}
            </a>
        </div>
    </div>
</x-public-layout>
