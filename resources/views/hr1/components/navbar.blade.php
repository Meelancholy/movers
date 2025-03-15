<div class="h-svh w-full overflow-y-auto bg-blue-950">
    <!-- top navbar  -->
    <nav x-data="{ mobileMenuIsOpen: false }" @click.away="mobileMenuIsOpen = false" class="sticky top-0 z-10 flex items-center justify-between border-b border-neutral-300 bg-white px-4 py-2" aria-label="top navibation bar">
    <!-- sidebar toggle button for small screens  -->
    <button type="button" class="md:hidden inline-block text-neutral-600" x-on:click="sidebarIsOpen = true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
            <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z"/>
        </svg>
        <span class="sr-only">sidebar toggle</span>
    </button>
    @php
        $segments = Request::segments();
        if ($segments[0] == 'dashboard') {
            array_shift($segments);
        }
    @endphp
    <nav class="flex px-4 py-3 text-gray-700 transition-transform duration-300 ease-in-out">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center ml-1 text-sm font-medium text-blue-400 hover:text-blue-800 md:ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" class="size-4 mr-1">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" />
                    </svg>
                    Dashboard
                </a>
            </li>
            @foreach ($segments as $index => $segment)
                <li>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        @php
                            $url = '/' . collect($segments)->slice(0, $index + 1)->implode('/');
                            $isId = is_numeric($segment);
                            $isUnclickable = in_array($segment, ['department', 'position']);
                        @endphp

                        @if ($index + 1 < count($segments) && !$isId && !$isUnclickable)
                            <a href="{{ url($url) }}" class="ml-1 text-sm font-medium text-blue-400 hover:text-blue-800 md:ml-2">
                                {{ ucfirst($segment) }}
                            </a>
                        @else
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                {{ ucfirst($segment) }}
                            </span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
    <!-- Desktop Menu -->
    <ul class="ml-auto flex hidden items-center gap-4 sm:flex">
        <!-- User Pic -->
        <li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }" @keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false" class="relative flex items-center">
            <div x-data="{ NotifisOpen: false, openedWithKeyboard: false }" class="mx-3 relative" @keydown.esc.window="NotifisOpen = false, openedWithKeyboard = false">
                <!-- Toggle Button -->
                <button class="flex items-center" type="button" @click="NotifisOpen = ! NotifisOpen" aria-haspopup="true" @keydown.space.prevent="openedWithKeyboard = true" @keydown.enter.prevent="openedWithKeyboard = true" @keydown.down.prevent="openedWithKeyboard = true" :class="NotifisOpen || openedWithKeyboard ? 'text-neutral-900 dark:text-white' : 'text-neutral-600 dark:text-neutral-300'" :aria-expanded="NotifisOpen || openedWithKeyboard">
                    <svg fill="SlateGray" class="size-10 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M10,21h4a2,2,0,0,1-4,0ZM3.076,18.383a1,1,0,0,1,.217-1.09L5,15.586V10a7.006,7.006,0,0,1,6-6.92V2a1,1,0,0,1,2,0V3.08A7.006,7.006,0,0,1,19,10v5.586l1.707,1.707A1,1,0,0,1,20,19H4A1,1,0,0,1,3.076,18.383ZM6.414,17H17.586l-.293-.293A1,1,0,0,1,17,16V10A5,5,0,0,0,7,10v6a1,1,0,0,1-.293.707Z"></path></g></svg>                        <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">1</div>
                </button>
                <!-- Dropdown Menu -->
                <div x-cloak x-show="NotifisOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard" @click.outside="NotifisOpen = false, openedWithKeyboard = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" class="absolute top-11 right-0 flex w-full min-w-[12rem] flex-col overflow-hidden rounded-md border border-neutral-300 bg-white p-4" role="menu">
                    <p>It's a Prank!</p>
                </div>
            </div>
            <button @click="userDropDownIsOpen = ! userDropDownIsOpen" :aria-expanded="userDropDownIsOpen" @keydown.space.prevent="openWithKeyboard = true" @keydown.enter.prevent="openWithKeyboard = true" @keydown.down.prevent="openWithKeyboard = true" class="flex items-center rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 mr-8" aria-controls="userMenu">
                <img src="{{ asset('images/profilepicdemo.jpg') }}" alt="User Profile" class="size-10 rounded-lg object-cover border" />
                <span class="text-sm font-medium text-neutral-900 ml-2">{{ Auth::user()->name }}</span>
            </button>
            <!-- User Dropdown -->
            <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity x-trap="openWithKeyboard" @click.outside="userDropDownIsOpen = false, openWithKeyboard = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" id="userMenu" class="absolute right-0 top-12 flex w-full min-w-[12rem] flex-col overflow-hidden rounded-md border border-neutral-300 bg-white py-1.5">
                <li class="border-b border-neutral-300">
                    <div class="flex flex-col px-4 py-2">
                        <span class="text-sm font-medium text-neutral-900">{{ Auth::user()->name }}</span>
                        <p class="text-xs text-neutral-600">{{ Auth::user()->email }}</p>
                    </div>
                </li>
                <li><a href="{{ route('dashboard') }}" class="block bg-white px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/10 focus-visible:text-neutral-900 focus-visible:outline-none">Dashboard</a></li>
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Settings') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </ul>
        </li>
    </ul>
    <!-- Mobile Menu Button -->
    <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" :aria-expanded="mobileMenuIsOpen" :class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button" class="flex ml-auto text-neutral-600 sm:hidden" aria-label="mobile menu" aria-controls="mobileMenu">
        <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
    <!-- Mobile Menu -->
    <ul x-cloak x-show="mobileMenuIsOpen" x-transition:enter="transition motion-reduce:transition-none ease-out duration-300" x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition motion-reduce:transition-none ease-out duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-md border-b border-neutral-300 bg-white px-8 pb-6 pt-10">
        <li class="mb-4 border-none">
            <div class="flex items-center gap-2 py-2">
                <img src="{{ asset('images/profilepicdemo.jpg') }}" alt="User Profile" class="size-12 rounded-full object-cover"  />
                <div>
                    <span class="font-medium text-neutral-900">{{ Auth::user()->name }}</span>
                    <p class="text-sm text-neutral-600">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </li>
        <hr role="none" class="my-2 border-outline">
        <li><a href="{{ route('dashboard') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out rounded-lg">Dashboard</a></li>
        <x-dropdown-link :href="route('profile.edit')">
            {{ __('Settings') }}
        </x-dropdown-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();" class="mt-4 w-full border-none rounded-md bg-blue-600 px-4 py-2 block text-center font-medium tracking-wide text-white hover:bg-blue-500 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 active:opacity-100 active:outline-offset-0">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </ul>
</nav>
