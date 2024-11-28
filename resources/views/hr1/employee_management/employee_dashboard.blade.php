@extends('hr1.layouts.app')

@section('content')
<div class="p-10 container min-w-full bg-white rounded-lg shadow-md">
    <!-- Title Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Employee Dashboard</h1>
    @if(session('success'))
        <div class="mb-5 relative w-full overflow-hidden rounded-md border border-green-500 bg-white text-neutral-600 text-black" role="alert">
            <div class="flex w-full items-center gap-2 bg-green-500/10 p-4">
                <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-green-500">Success</h3>
                    <p class="text-xs font-medium sm:text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    <!-- Employee Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-400 text-white p-6 rounded-xl shadow-md hover:bg-blue-300 transition duration-300 ease-in-out">
            <h2 class="text-lg font-semibold">Total Employees</h2>
            <p class="text-4xl mt-2">{{ $totalEmployees }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-xl shadow-md hover:bg-green-400 transition duration-300 ease-in-out">
            <h2 class="text-lg font-semibold">Active Employees</h2>
            <p class="text-4xl mt-2">{{ $activeEmployees }}</p>
        </div>
        <div class="bg-red-500 text-white p-6 rounded-xl shadow-md hover:bg-red-400 transition duration-300 ease-in-out">
            <h2 class="text-lg font-semibold">Inactive Employees</h2>
            <p class="text-4xl mt-2">{{ $inactiveEmployees }}</p>
        </div>
    </div>
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @livewire('employee-management.employee-create')
        <a href="{{ route('employee.list') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            View All Employees
        </a>
        @livewire('department.position-create')
        @livewire('department.department-create')
    </div>
    <div x-data="{ selectedTab: 'departments' }" class="w-full">
        <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()" class="flex gap-2 overflow-x-auto border-b border-neutral-300" role="tablist" aria-label="tab options">
            <button @click="selectedTab = 'departments'" :aria-selected="selectedTab === 'departments'" :tabindex="selectedTab === 'departments' ? '0' : '-1'" :class="selectedTab === 'departments' ? 'font-bold text-blue-500 border-b-2 border-blue-500' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'" class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelDepartments" >
                Departments
                <span :class="selectedTab === 'departments' ? 'text-white border-black bg-blue-500' : 'border-neutral-300 bg-neutral-100'" class="text-xs font-medium px-1 rounded-full">{{ $totalDepartments }}</span>
            </button>
            <button @click="selectedTab = 'positions'" :aria-selected="selectedTab === 'positions'" :tabindex="selectedTab === 'positions' ? '0' : '-1'" :class="selectedTab === 'positions' ? 'font-bold text-blue-500 border-b-2 border-blue-500' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'" class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelPositions" >
                Positions
                <span :class="selectedTab === 'positions' ? 'text-white border-black bg-blue-500' : 'border-neutral-300 bg-neutral-100'" class="text-xs font-medium px-1 rounded-full">{{ $totalPositions }}</span>
            </button>
        </div>
        <div class="px-2 py-4 text-neutral-600">
            <div x-show="selectedTab === 'departments'" id="tabpanelDepartments" role="tabpanel" aria-label="departments">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Departments</h2>
                <div class="overflow-hidden w-full overflow-x-auto rounded-none">
                    <table class="w-full text-left text-sm text-neutral-600">
                        <thead class=" bg-neutral-100 text-sm text-neutral-900">
                            <tr>
                                <th scope="col" class="p-4">Department Name</th>
                                <th scope="col" class="p-4 text-center">Number of Positions</th>
                                <th scope="col" class="p-4 text-center">Number of Employees</th>
                                <th scope="col" class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-300">
                            @foreach($departments as $department)
                                <tr>
                                    <td class="p-4">{{ $department->name }}</td>
                                    <td class="p-4 text-center">{{ $department->positions_count }}</td>
                                    <td class="p-4 text-center">{{ $department->employees_count }}</td>
                                    <td class="p-4 flex items-center justify-center">
                                        <a href="{{ route('department.edit', $department->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                        </a>
                                        <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div x-show="selectedTab === 'positions'" id="tabpanelPositions" role="tabpanel" aria-label="positions">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Positions</h2>
                <div class="overflow-hidden rounded-xl shadow-lg">
                    <table class="w-full bg-white border-collapse table-auto">
                        <thead class="bg-blue-100 text-gray-800">
                            <tr>
                                <th class="p-4 text-left">Position</th>
                                <th class="p-4 text-center">Number of Employees</th>
                                <th class="p-4 text-left hidden md:table-cell">Base Salary</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($positions as $position)
                                <tr class="hover:bg-blue-50 transition duration-300 ease-in-out">
                                    <td class="p-4 text-gray-800">{{ $position->name }}</td>
                                    <td class="p-4 text-center text-gray-800">{{ $position->employees_count }}</td>
                                    <td class="p-4 hidden md:table-cell text-gray-800">{{ number_format($position->base_salary, 2) }}</td>
                                    <td class="p-4 flex items-center justify-center">
                                        <a href="{{ route('position.edit', $position->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                        </a>
                                        <form action="{{ route('position.destroy', $position->id) }}" method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
