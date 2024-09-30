<!-- resources/views/components/hr1-sidebar.blade.php -->
<div class="sidebar">
<aside x-data="{ open: $parent.open }" :class="open ? 'translate-x-0' : '-translate-x-full'" class="p-4 w-64 bg-white font-bold min-h-full border-2 text-blue-600 fixed transform transition-transform duration-300 ease-in-out">
    <a href="{{ route('dashboard') }}"><img class="py-7" src="{{ asset('images/logo.png') }}" alt="Logo"></a>
        <!-- Add horizontal line -->
        <hr class="border-gray-300 my-4">
        <ul class="text-l">
            <li>
                <a href="{{ route('dashboard') }}" class="flex text-blue-600 hover:text-blue-800 cursor-pointer">
                    <!-- SVG Icon -->
                    <svg class="pr-2" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1"/>
                        <rect width="7" height="5" x="14" y="3" rx="1"/>
                        <rect width="7" height="9" x="14" y="12" rx="1"/>
                        <rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                    Dashboard
            </a>
        </li>
        <li x-data="{ open: false }">
            <a @click="open = !open" class="flex items-center justify-between py-2 text-blue-600 hover:text-blue-800 cursor-pointer">
                <span class="flex items-center">
                    <!-- SVG Icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    HR Management
                </span>
                <!-- Dropdown Arrow -->
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ '-rotate-90': !open }" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>
            <ul x-show="open" class="pl-4 mt-2 space-y-1">
                <li><a href="{{ route('employees.index') }}" class="block py-2 text-blue-600 hover:text-blue-800">Employees</a></li>
                <li><a href="{{ route('departments.index') }}" class="block py-2 text-blue-600 hover:text-blue-800">Departments</a></li>
                <li><a href="{{ route('positions.index') }}" class="block py-2 text-blue-600 hover:text-blue-800">Positions</a></li>
            </ul>
        </li>
        <li x-data="{ open: false }">
            <a href="#" @click="open = !open" class="flex items-center justify-between py-2 text-blue-600 hover:text-blue-800 cursor-pointer">
                <span class="flex items-center">
                    <!-- SVG Icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Payroll
                </span>
                <!-- Dropdown Arrow -->
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ '-rotate-90': !open }" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>
            <ul x-show="open" class="pl-4 mt-2 space-y-1">
                <li><a href="{{ route('payroll') }}" class="block py-2 text-blue-600 hover:text-blue-800">Overview</a></li>
                <li><a href="{{ route('payroll-records') }}" class="block py-2 text-blue-600 hover:text-blue-800">Records</a></li>
                <li><a href="{{ route('bonus-deduction') }}" class="block py-2 text-blue-600 hover:text-blue-800">Bonus, Deductions and Allowances</a></li>
            </ul>
        </li>
        <li x-data="{ open: false }">
            <a href="#" @click="open = !open" class="flex items-center justify-between py-2 text-blue-600 hover:text-blue-800 cursor-pointer">
                <span class="flex items-center">
                    <!-- SVG Icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Compensation and Benefits
                </span>
                <!-- Dropdown Arrow -->
                <svg class="w-5 h-5 transition-transform duration-300" :class="{ '-rotate-90': !open }" fill="none" stroke="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>
            <ul x-show="open" class="pl-4 mt-2 space-y-1">
                <li><a href="#" class="block py-2 text-blue-600 hover:text-blue-800">Benefits Review</a></li>
                <li><a href="#" class="block py-2 text-blue-600 hover:text-blue-800">Manage Benefits</a></li>
                <li><a href="#" class="block py-2 text-blue-600 hover:text-blue-800">Compensation Package</a></li>
                <li><a href="#" class="block py-2 text-blue-600 hover:text-blue-800">Claims and Request</a></li>
                <li><a href="#" class="block py-2 text-blue-600 hover:text-blue-800">Compensation Reports</a></li>
            </ul>
        </li>
    </ul>
</aside>
</div>
