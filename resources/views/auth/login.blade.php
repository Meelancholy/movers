<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto p-2">
        @csrf
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="object-contain transition-transform duration-300 transform hover:scale-110">
        </div>

        <!-- Email or Name Address -->
        <div class="mb-6">
            <x-input-label for="login" :value="__('Username or Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="login" class="block mt-2 w-full px-5 py-3 border border-gray-300 bg-gray-50 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-300 ease-in-out transform hover:scale-105"
                type="text" name="login" :value="old('login')" autofocus />
            <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password" class="block mt-2 w-full px-5 py-3 border border-gray-300 bg-gray-50 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-300 ease-in-out transform hover:scale-105"
                type="password" name="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center text-gray-600">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 transition duration-300 transform hover:scale-105" name="remember">
                <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="flex">
            <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-700 focus:bg-blue-800 text-white font-semibold rounded-lg transition-transform duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg">
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
