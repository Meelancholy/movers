<!-- resources/views/components/hr1-sidebar.blade.php -->
<div class="sidebar">
    <aside x-data="{ open: $parent.open }" :class="open ? 'translate-x-0' : '-translate-x-full'" class="p-5 w-64 bg-white font-bold min-h-full border-2 text-blue-600 fixed transform transition-transform duration-300 ease-in-out">

        <button @click="open = false" class="absolute top-4 right-4 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}">
            <img class="py-7" src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>
        <hr class="border-gray-300 my-4">
        <ul class="text-l">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer py-4">
                    <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#000000" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1"/>
                        <rect width="7" height="5" x="14" y="3" rx="1"/>
                        <rect width="7" height="9" x="14" y="12" rx="1"/>
                        <rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="text-gray-400 text-sm pt-4">
                Modules
            </li>
            <!-- HR Management Menu -->
            <li x-data="{ open: false }">
                <a @click="open = !open" class="flex items-center justify-between py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        HR Management
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
                    <li><a href="{{ route('employees.index') }}" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Employees</a></li>
                    <li><a href="{{ route('departments.index') }}" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Departments</a></li>
                    <li><a href="{{ route('positions.index') }}" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Positions</a></li>
                </ul>
            </li>

            <!-- Payroll Menu -->
            <li x-data="{ open: false }">
                <a @click="open = !open" class="flex items-center justify-between py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
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
                    <li><a href="{{ route('payroll') }}" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Overview</a></li>
                    <li><a href="{{ route('payroll-records') }}" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Records</a></li>
                    <li><a href="{{ route('bonus-deduction') }}" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Bonus, Deductions, and Allowances</a></li>
                </ul>
            </li>

            <!-- Compensation & Benefits Menu -->
            <li x-data="{ open: false }">
                <a @click="open = !open" class="flex items-center justify-between py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800 cursor-pointer">
                    <span class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Compensation & Benefits
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
                    <li><a href="#" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Benefits Review</a></li>
                    <li><a href="#" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Manage Benefits</a></li>
                    <li><a href="#" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Compensation Package</a></li>
                    <li><a href="#" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Claims and Request</a></li>
                    <li><a href="#" class="block py-4 px-2 rounded-lg text-blue-600 hover:bg-blue-200 active:bg-blue-400 hover:text-blue-800">Compensation Reports</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
