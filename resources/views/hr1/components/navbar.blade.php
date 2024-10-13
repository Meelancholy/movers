<nav class="bg-white p-4 shadow-lg flex items-center">
    <div class="flex w-full items-center">

        <!-- Sidebar toggle button (aligned to the left) -->
        <button :class="open ? 'translate-x-80' : 'translate-x-0'" @click="open = !open; rotate = !rotate" class="text-blue-600 hover:text-blue-800 focus:outline-none transition-transform duration-300 ease-in-out">
            <svg :class="{ 'rotate-180': rotate }" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 ease-in-out">
                <rect width="18" height="18" x="3" y="3" rx="2"/>
                <path d="M15 3v18"/>
                <path d="m8 9 3 3-3 3"/>
            </svg>
        </button>

        <!-- Push the remaining content to the right -->
        <div class="ml-auto flex items-center space-x-4">

            <!-- Icons: Notifications and Messages -->
            <div class="flex items-center space-x-4">
                <!-- Notifications Icon -->
                <button class="relative focus:outline-none">
                    <svg class="h-6 w-6 text-gray-600 hover:text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C19.835 14.979 20 14.257 20 13.5V11c0-3.039-1.312-5.466-3.354-7.007A9.965 9.965 0 0012 3c-2.602 0-4.975 1.047-6.646 2.793C3.477 7.367 3 9.633 3 12v1.5c0 .757.165 1.479.405 2.095L2 17h5m6 4v1m-4 0h4" />
                    </svg>
                    <!-- Notification Badge -->
                    <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Messages Icon -->
                <button class="relative focus:outline-none">
                    <svg class="h-6 w-6 text-gray-600 hover:text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2m4-4h2a2 2 0 012 2v4H9V6a2 2 0 012-2z" />
                    </svg>
                </button>
            </div>

            <!-- Right-side profile dropdown -->
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ asset('images/logo.png') }}" alt="Profile Picture" class="w-10 h-10 rounded-full object-cover">
                            <div class="hidden sm:block pl-2">{{ Auth::user()->name }}</div>

                            <!-- Mobile-friendly dropdown icon -->
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
