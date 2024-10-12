<nav class="bg-white p-4 shadow-lg flex">
    <div class="container flex justify-between items-center w-full">
        <!-- Sidebar toggle button -->
        <button :class="open ? 'translate-x-80' : 'translate-x-0'" @click="open = !open; rotate = !rotate" class="text-blue-600 hover:text-blue-800 focus:outline-none transition-transform duration-300 ease-in-out">
            <svg :class="{ 'rotate-180': rotate }" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 ease-in-out">
                <rect width="18" height="18" x="3" y="3" rx="2"/>
                <path d="M15 3v18"/>
                <path d="m8 9 3 3-3 3"/>
            </svg>
        </button>

        <!-- Right-side profile dropdown -->
        <div class="flex items-center ml-auto">
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
</nav>
