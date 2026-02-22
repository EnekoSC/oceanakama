<x-public-layout>
    <x-slot:title>{{ __('Verificar email') }}</x-slot:title>

    <div class="min-h-[60vh] flex items-center justify-center px-4 sm:px-6">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-6">
                <span class="text-2xl font-bold text-cyan-700">oceaNakama</span>
            </div>

            <p class="text-sm text-gray-600 mb-5">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-5 text-sm font-medium text-green-600 bg-green-50 rounded-lg p-3">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-cyan-700 text-white text-sm font-medium rounded-lg hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-cyan-700 transition">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>
