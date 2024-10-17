<div class="sidebar">
    <aside x-data="{ open: $parent.open }" :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="p-1 w-72 bg-white font-bold text-sm min-h-full border-2 text-blue-500 fixed transform transition-transform duration-300 ease-in-out max-h-screen overflow-y-auto">

        <button @click="open = false" class="absolute top-4 right-4 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <a href="{{route('dashboard')}}">
            <img class="p-6" src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>


        <ul class="text-l">
            <li>
                <a href="{{route('dashboard')}}" class="flex items-center px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer py-4">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1"/>
                        <rect width="7" height="5" x="14" y="3" rx="1"/>
                        <rect width="7" height="9" x="14" y="12" rx="1"/>
                        <rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="text-gray-400 text-sm pt-5">
                Services
            </li>
            <!-- HR Management Menu -->
            <li x-data="{ open: false }">
                <a @click="open = !open" class="flex items-center justify-between py-4 px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m21.7 16.4-.9-.3"/><path d="m15.2 13.9-.9-.3"/><path d="m16.6 18.7.3-.9"/><path d="m19.1 12.2.3-.9"/><path d="m19.6 18.7-.4-1"/><path d="m16.8 12.3-.4-1"/><path d="m14.3 16.6 1-.4"/><path d="m20.7 13.8 1-.4"/></svg>

                        Employee Management
                    </span>
                    <svg class="w-5 h-5 transition-transform duration-300" :class="{ '-rotate-90': !open }" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                <ul x-show="open" x-transition:enter="transition-all ease-in-out duration-300 transform"
                    x-transition:enter-start="max-h-0 opacity-0"
                    x-transition:enter-end="max-h-full opacity-100"
                    x-transition:leave="transition-all ease-in-out duration-300 transform"
                    x-transition:leave-start="max-h-full opacity-100"
                    x-transition:leave-end="max-h-0 opacity-0"
                    class="pl-4 mt-2 space-y-1 overflow-hidden">
                    <li><a href="{{ route('employee.dashboard') }}" class="flex items-center py-4 px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 2v2"/><path d="M7 22v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/><path d="M8 2v2"/><circle cx="12" cy="11" r="3"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg>
                        Employee Dashboard</a></li>
                    <li><a href="{{ route('employee.list') }}" class="flex items-center py-4 px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>

                        Employee List</a></li>
                </ul>
            </li>
            <!-- Payroll Menu -->
            <li x-data="{ open: false }">
                <a @click="open = !open" class="flex items-center justify-between py-4 px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg>
                        <!-- Vertical Divider -->

                        Payroll
                    </span>
                    <svg class="w-5 h-5 transition-transform duration-300" :class="{ '-rotate-90': !open }" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                <ul x-show="open" x-transition:enter="transition-all ease-in-out duration-300 transform"
                    x-transition:enter-start="max-h-0 opacity-0"
                    x-transition:enter-end="max-h-full opacity-100"
                    x-transition:leave="transition-all ease-in-out duration-300 transform"
                    x-transition:leave-start="max-h-full opacity-100"
                    x-transition:leave-end="max-h-0 opacity-0"
                    class="pl-4 mt-2 space-y-1 overflow-hidden">

                    <li>
                        <a href="{{ route('payroll.generate') }}" class="flex items-center py-4 px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>

                            Generate Payroll
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('payroll.records') }}" class="flex items-center py-4 px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>

                            Payroll Records
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{route('compensation.index')}}" class="flex items-center px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer py-4">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>

                    Compensation & Benefits
                </a>
            </li>

            <li class="text-gray-400 text-sm pt-4">
                User Support
            </li>
            <li>
                <a href="{{route('profile.edit')}}" class="flex items-center px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer py-4">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>

                    Settings
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-2 rounded-lg text-blue-500 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer py-4">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="mr-2" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/><circle cx="12" cy="12" r="4"/></svg>

                    Help
                </a>
            </li>
        </ul>
    </aside>
</div>
