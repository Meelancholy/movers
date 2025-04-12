<x-guest-layout>
    <div>
        <div class="max-w-md w-full space-y-8 bg-white p-10">
            <!-- Logo/Header -->
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Two-Factor Verification') }}
                </h2>
            </div>

            <form method="POST" action="{{ route('two-factor.verify') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Verification Message -->
                <div class="text-center text-gray-600">
                    <p>We've sent a 6-digit verification code to your email.</p>
                    <p class="mt-1">Please enter it below to continue.</p>
                </div>

                <!-- Code Input -->
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="code" class="sr-only">{{ __('Verification Code') }}</label>
                        <input id="code" name="code" type="text" inputmode="numeric" required
                            class="appearance-none relative block w-full px-5 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm text-center tracking-widest text-xl"
                            placeholder="• • • • • •"
                            maxlength="6"
                            pattern="\d{6}"
                            title="Please enter exactly 6 digits"
                            autocomplete="off"
                            autofocus>
                    </div>
                </div>

                @error('code')
                    <div class="text-red-600 text-sm text-center mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        {{ __('Verify') }}
                    </button>
                </div>

                <div class="text-center">
                    <button type="button" onclick="document.getElementById('resend-form').submit()"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                        {{ __('Resend Verification Code') }}
                    </button>
                </div>
            </form>

            <form id="resend-form" method="POST" action="{{ route('two-factor.resend') }}">
                @csrf
            </form>
        </div>
    </div>
</x-guest-layout>
