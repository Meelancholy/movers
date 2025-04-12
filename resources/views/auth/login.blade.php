<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto p-2" x-data="{ isLoading: false }" @submit="isLoading = true">
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
        <div x-data="{ show: false }" class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <div class="relative mt-2">
                <x-text-input
                    id="password"
                    class="block w-full px-5 py-3 border border-gray-300 bg-gray-50 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-300 ease-in-out transform hover:scale-105"
                    x-bind:type="show ? 'text' : 'password'"
                    name="password"
                    autocomplete="current-password"
                />
                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 transition duration-200">
                    <span x-show="!show"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                      </svg>
                      </span>
                    <span x-show="show"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                        <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                        <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                      </svg>
                      </span>
                </button>
            </div>
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
            <x-primary-button
                class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-700 focus:bg-blue-800 text-white font-semibold rounded-lg transition-transform duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg"
                x-bind:disabled="isLoading"
                x-bind:class="{ 'opacity-75 cursor-not-allowed': isLoading }"
            >
                <span x-show="!isLoading">{{ __('Login') }}</span>
                <span x-show="isLoading" class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
