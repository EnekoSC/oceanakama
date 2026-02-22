<x-public-layout>
    <x-slot:title>{{ __('Editar perfil') }}</x-slot:title>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Editar perfil') }}</h1>
            <p class="mt-1 text-gray-500">{{ auth()->user()->email }}</p>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-public-layout>
