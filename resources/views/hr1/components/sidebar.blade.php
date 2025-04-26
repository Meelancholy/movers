<nav x-cloak class="fixed left-0 z-30 flex h-svh w-72 shrink-0 flex-col border-r border-neutral-300 bg-white p-4 transition-transform duration-300 md:w-72 md:translate-x-0 md:relative" x-bind:class="sidebarIsOpen ? 'translate-x-0' : '-translate-x-72'" aria-label="sidebar navigation">
    <!-- logo  -->
    <a href="{{route('dashboard')}}">
        <img class="p-3" src="{{ asset('images/logo.png') }}" alt="Logo">
    </a>
    <hr class="divider p-2">
    <!-- sidebar links  -->
    <div class="flex flex-col gap-2 overflow-y-auto pb-6">
        <a
            @if(request()->routeIs('dashboard'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('dashboard') }}"
            @endif>
            <svg fill="currentColor" viewBox="-2.4 -2.4 28.80 28.80" class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg">
                <rect x="2" y="2" width="9" height="11" rx="2"></rect>
                <rect x="13" y="2" width="9" height="7" rx="2"></rect>
                <rect x="2" y="15" width="9" height="7" rx="2"></rect>
                <rect x="13" y="11" width="9" height="11" rx="2"></rect>
            </svg>
            <span>Dashboard</span>
        </a>

        @if(request()->routeIs('employee.dashboard') || request()->routeIs('payroll.dashboard'))
            <div x-data="{ isExpanded: true }" class="flex flex-col">
        @else
            <div x-data="{ isExpanded: false }" class="flex flex-col">
        @endif

    </div>
    <hr class="divider p-2">
    <h6 class="text-xs font-bold text-neutral-700">Services</h6>
        <a
            @if(request()->routeIs('employee.list'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('employee.list') }}"
            @endif>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0" aria-hidden="true">
                <path fill-rule="evenodd" d="M1 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H4a3 3 0 0 1-3-3V6Zm4 1.5a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2 3a4 4 0 0 0-3.665 2.395.75.75 0 0 0 .416 1A8.98 8.98 0 0 0 7 14.5a8.98 8.98 0 0 0 3.249-.604.75.75 0 0 0 .416-1.001A4.001 4.001 0 0 0 7 10.5Zm5-3.75a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75Zm0 6.5a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75Zm.75-4a.75.75 0 0 0 0 1.5h2.5a.75.75 0 0 0 0-1.5h-2.5Z" clip-rule="evenodd"/>
            </svg>
            <span>Active Employees</span>
        </a>
            <a
                @if(request()->routeIs('employee.archive'))
                    class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                    href="javascript:void(0);"
                    aria-disabled="true"
                @else
                    class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                    href="{{ route('employee.archive') }}"
                @endif>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0" aria-hidden="true">
                    <path fill-rule="evenodd" d="M1 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H4a3 3 0 0 1-3-3V6Zm4 1.5a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2 3a4 4 0 0 0-3.665 2.395.75.75 0 0 0 .416 1A8.98 8.98 0 0 0 7 14.5a8.98 8.98 0 0 0 3.249-.604.75.75 0 0 0 .416-1.001A4.001 4.001 0 0 0 7 10.5Zm5-3.75a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75Zm0 6.5a.75.75 0 0 1 .75-.75h2.5a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 1-.75-.75Zm.75-4a.75.75 0 0 0 0 1.5h2.5a.75.75 0 0 0 0-1.5h-2.5Z" clip-rule="evenodd"/>
                </svg>
                <span>Employee Archive</span>
            </a>
            <a
            @if(request()->routeIs('compensation.index'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('compensation.index') }}"
            @endif>
            <svg fill="currentColor" class="size-5 shrink-0" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g data-name="10. Growth" id="_10._Growth"> <path d="M17,12.05V11h3a5,5,0,0,0,5-5V4a1,1,0,0,0-1-1H20a4.92,4.92,0,0,0-3,1V1a1,1,0,0,0-2,0V2a4.92,4.92,0,0,0-3-1H8A1,1,0,0,0,7,2V4a5,5,0,0,0,5,5h3v3.05a10,10,0,1,0,2,0Zm3-7h3V6a3,3,0,0,1-3,3H17V8A3,3,0,0,1,20,5ZM9,4V3h3a3,3,0,0,1,3,3V7H12A3,3,0,0,1,9,4Zm7,26a8,8,0,1,1,8-8A8,8,0,0,1,16,30Z"></path> <path d="M16,19h2a1,1,0,0,0,0-2H17a1,1,0,0,0-2,0v.18A3,3,0,0,0,16,23a1,1,0,0,1,0,2H14a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,16,21a1,1,0,0,1,0-2Z"></path> <path d="M5.71,7.29l-2-2a1,1,0,0,0-1.42,0l-2,2A1,1,0,0,0,1.71,8.71L2,8.41V11a1,1,0,0,0,2,0V8.41l.29.3a1,1,0,0,0,1.42,0A1,1,0,0,0,5.71,7.29Z"></path> <path d="M31.71,13.29l-2-2a1,1,0,0,0-1.42,0l-2,2a1,1,0,0,0,1.42,1.42l.29-.3V17a1,1,0,0,0,2,0V14.41l.29.3a1,1,0,0,0,1.42,0A1,1,0,0,0,31.71,13.29Z"></path> </g> </g>
            </svg>
            <span>Compensation & Benefits</span>
        </a>
        <a
            @if(request()->routeIs('payroll.generate'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('payroll.generate') }}"
            @endif>
            <svg fill="currentColor" class="size-5 shrink-0" height="200px" width="200px" version="1.1" id="Money" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 128 128" xml:space="preserve">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="_x34__5_"> <path d="M17.6,41.9v53h102.3v-53H17.6z M37.5,87.6h-12v-12h2.4v9.6h9.6V87.6z M37.5,51.5h-9.6v9.6h-2.4v-12h12V51.5z M68.8,87.6 c-10.6,0-19.3-8.6-19.3-19.3c0-10.6,8.6-19.3,19.3-19.3s19.3,8.6,19.3,19.3C88.1,79,79.4,87.6,68.8,87.6z M113.3,87.6h-12v-2.4h9.6 v-9.6h2.4V87.6z M113.3,61.1h-2.4v-9.6h-9.6v-2.4h12V61.1z"></path> </g> <path id="_x33__9_" d="M76.7,73c0-3.2-1.9-5.4-6-6.9c-3-1.1-4.3-1.8-4.3-3.2c0-1.2,1.1-2.2,3.3-2.2c2.3,0,3.9,0.6,4.8,1.1l1.2-4.2 c-1-0.5-2.3-0.9-4-1.1v-3.4h-5.9v4c-2.9,1.1-4.6,3.4-4.6,6.2c0,3.3,2.5,5.5,6.3,6.8c2.8,1,3.9,1.8,3.9,3.2c0,1.5-1.3,2.5-3.6,2.5 c-2.2,0-4.4-0.7-5.8-1.4l-1.1,4.3c1,0.6,2.9,1.1,4.9,1.3v3.3h5.9v-3.8C75.1,78.4,76.7,75.9,76.7,73z"></path> <polygon id="_x32__17_" points="115.1,37 12.8,37 12.8,89.4 15.2,89.4 15.2,39.5 115.1,39.5 "></polygon> <polygon id="_x31__6_" points="110.3,32.2 8,32.2 8,84.6 10.4,84.6 10.4,34.6 110.3,34.6 "></polygon> </g></svg>
            <span>Generate Payroll</span>
        </a>
        <a
            @if(request()->routeIs('payroll.records'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('payroll.records') }}"
            @endif>
            <svg fill="currentColor" class="size-5 shrink-0" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier">
                <g data-name="18. Bill" id="_18._Bill"> <path d="M16,7h2a1,1,0,0,0,0-2H17a1,1,0,0,0-2,0v.18A3,3,0,0,0,16,11a1,1,0,0,1,0,2H14a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,16,9a1,1,0,0,1,0-2Z"></path> <path d="M31,24H28V3a3,3,0,0,0-3-3H3A3,3,0,0,0,0,3V9a1,1,0,0,0,1,1H4V29a3,3,0,0,0,3,3H29a3,3,0,0,0,3-3V25A1,1,0,0,0,31,24ZM2,3A1,1,0,0,1,4,3V8H2ZM8,25v4a1,1,0,0,1-.31.71A.93.93,0,0,1,7,30a1,1,0,0,1-1-1V3a3,3,0,0,0-.18-1H25a1,1,0,0,1,1,1V24H9A1,1,0,0,0,8,25Zm22,4a1,1,0,0,1-.31.71A.93.93,0,0,1,29,30H9.83A3,3,0,0,0,10,29V26H30Z"></path> <path d="M17,19H9a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z"></path> <path d="M23,19H21a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"></path> </g> </g></svg>
            <span>Payroll Records</span>
        </a>
            <a
            @if(request()->routeIs('payroll-forecast.index'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('payroll-forecast.index') }}"
            @endif>
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up-down-icon lucide-trending-up-down"><path d="M14.828 14.828 21 21"/><path d="M21 16v5h-5"/><path d="m21 3-9 9-4-4-6 6"/><path d="M21 8V3h-5"/></svg>
            <span>Payroll Budget</span>
        </a>
    </div>
    <div class="mt-auto">
        <h6 class="text-xs font-bold text-neutral-700">Support</h6>
        <a
            @if(request()->routeIs('privacypolicy'))
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium border border-blue-500 bg-blue-600 text-white cursor-not-allowed hover:text-blue-900 hover:bg-blue-600/5"
                href="javascript:void(0);"
                aria-disabled="true"
            @else
                class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none"
                href="{{ route('privacypolicy') }}"
            @endif>
            <svg fill="currentColor" class="size-5 shrink-0" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g data-name="10. Growth" id="_10._Growth"> <path d="M17,12.05V11h3a5,5,0,0,0,5-5V4a1,1,0,0,0-1-1H20a4.92,4.92,0,0,0-3,1V1a1,1,0,0,0-2,0V2a4.92,4.92,0,0,0-3-1H8A1,1,0,0,0,7,2V4a5,5,0,0,0,5,5h3v3.05a10,10,0,1,0,2,0Zm3-7h3V6a3,3,0,0,1-3,3H17V8A3,3,0,0,1,20,5ZM9,4V3h3a3,3,0,0,1,3,3V7H12A3,3,0,0,1,9,4Zm7,26a8,8,0,1,1,8-8A8,8,0,0,1,16,30Z"></path> <path d="M16,19h2a1,1,0,0,0,0-2H17a1,1,0,0,0-2,0v.18A3,3,0,0,0,16,23a1,1,0,0,1,0,2H14a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,16,21a1,1,0,0,1,0-2Z"></path> <path d="M5.71,7.29l-2-2a1,1,0,0,0-1.42,0l-2,2A1,1,0,0,0,1.71,8.71L2,8.41V11a1,1,0,0,0,2,0V8.41l.29.3a1,1,0,0,0,1.42,0A1,1,0,0,0,5.71,7.29Z"></path> <path d="M31.71,13.29l-2-2a1,1,0,0,0-1.42,0l-2,2a1,1,0,0,0,1.42,1.42l.29-.3V17a1,1,0,0,0,2,0V14.41l.29.3a1,1,0,0,0,1.42,0A1,1,0,0,0,31.71,13.29Z"></path> </g> </g>
            </svg>
            <span>Privacy Policy</span>
        </a>
        <a href="{{route('profile.edit')}}" class="flex items-center rounded-md gap-2 px-2 py-3 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-blue-600/5 hover:text-blue-900 focus-visible:underline focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.84 1.804A1 1 0 0 1 8.82 1h2.36a1 1 0 0 1 .98.804l.331 1.652a6.993 6.993 0 0 1 1.929 1.115l1.598-.54a1 1 0 0 1 1.186.447l1.18 2.044a1 1 0 0 1-.205 1.251l-1.267 1.113a7.047 7.047 0 0 1 0 2.228l1.267 1.113a1 1 0 0 1 .206 1.25l-1.18 2.045a1 1 0 0 1-1.187.447l-1.598-.54a6.993 6.993 0 0 1-1.929 1.115l-.33 1.652a1 1 0 0 1-.98.804H8.82a1 1 0 0 1-.98-.804l-.331-1.652a6.993 6.993 0 0 1-1.929-1.115l-1.598.54a1 1 0 0 1-1.186-.447l-1.18-2.044a1 1 0 0 1 .205-1.251l1.267-1.114a7.05 7.05 0 0 1 0-2.227L1.821 7.773a1 1 0 0 1-.206-1.25l1.18-2.045a1 1 0 0 1 1.187-.447l1.598.54A6.992 6.992 0 0 1 7.51 3.456l.33-1.652ZM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
            </svg>
            <span>Settings</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();" class="flex bg-red-500 items-center border border-red-500 rounded-md gap-2 px-2 py-3 text-sm font-medium text-white underline-offset-2 hover:bg-red-600/5 hover:text-red-700 focus-visible:underline focus:outline-none">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </div>
</nav>
