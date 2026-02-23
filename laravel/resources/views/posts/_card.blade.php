<article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition group">
    <a href="{{ lroute('blog.show', $post->slug) }}">
        @if($post->imagen_url)
            <img src="{{ Storage::url($post->imagen_url) }}" alt="{{ $post->titulo }}"
                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300" loading="lazy">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-cyan-600 to-cyan-800 flex items-center justify-center">
                <svg class="w-16 h-16 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5"/></svg>
            </div>
        @endif
    </a>
    <div class="p-5">
        @if($post->published_at)
            <p class="text-xs text-gray-500 mb-2">
                {{ __('Publicado el') }} {{ $post->published_at->format('d/m/Y') }}
            </p>
        @endif
        <h3 class="font-semibold text-gray-900 mb-2">
            <a href="{{ lroute('blog.show', $post->slug) }}" class="hover:text-cyan-700 transition">
                {{ $post->titulo }}
            </a>
        </h3>
        @if($post->extracto)
            <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ $post->extracto }}</p>
        @endif
        <a href="{{ lroute('blog.show', $post->slug) }}" class="text-sm font-medium text-cyan-700 hover:text-cyan-800 transition">
            {{ __('Leer más') }} &rarr;
        </a>
    </div>
</article>
