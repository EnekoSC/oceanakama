<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'oceaNakama') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6">
            <div class="mb-8">
                <a href="/" class="text-3xl font-bold text-cyan-700">
                    oceaNakama
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white rounded-xl shadow-lg p-8">
                {{ $slot }}
            </div>

            <div class="mt-6 flex items-center space-x-3">
                <a href="{{ url(request()->getPathInfo() . '?' . http_build_query(array_merge(request()->query(), ['lang' => 'es']))) }}"
                   class="text-sm {{ app()->getLocale() === 'es' ? 'text-cyan-700 font-medium' : 'text-gray-500 hover:text-cyan-700' }} transition">ES</a>
                <span class="w-px h-4 bg-gray-300"></span>
                <a href="{{ url(request()->getPathInfo() . '?' . http_build_query(array_merge(request()->query(), ['lang' => 'en']))) }}"
                   class="text-sm {{ app()->getLocale() === 'en' ? 'text-cyan-700 font-medium' : 'text-gray-500 hover:text-cyan-700' }} transition">EN</a>
            </div>
        </div>
    </body>
</html>
