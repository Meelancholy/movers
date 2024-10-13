@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container mx-auto">
    <!-- Title Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Employee Dashboard</h1>

    <!-- Employee Stats Cards with Gradients -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-6 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold">Total Employees</h2>
            <p class="text-4xl mt-2">{{ $totalEmployees }}</p>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold">Active Employees</h2>
            <p class="text-4xl mt-2">{{ $activeEmployees }}</p>
        </div>
        <div class="bg-gradient-to-r from-red-400 to-red-600 text-white p-6 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold">Inactive Employees</h2>
            <p class="text-4xl mt-2">{{ $inactiveEmployees }}</p>
        </div>
    </div>

    <!-- Quick Actions with Gradients -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('employee.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Employee
        </a>
        <a href="{{ route('employee.list') }}" class="bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            View All Employees
        </a>
        <a href="{{ route('department.create') }}" class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Department
        </a>
        <a href="{{ route('position.create') }}" class="bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Position
        </a>
    </div>

    <!-- Employees by Department -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Employees by Department</h2>
        <ul class="bg-white shadow-lg rounded-xl divide-y divide-gray-200">
            @foreach($departments as $department)
                <li class="flex justify-between items-center px-6 py-4 hover:bg-gray-100 transition duration-200 rounded-xl">
                    <span class="text-lg text-gray-700 font-medium">{{ $department->name }}</span>
                    <span class="text-gray-500">{{ $department->employees_count }} Employees</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Positions Table with Gradients -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Positions</h2>
        <div class="overflow-hidden rounded-xl shadow-lg">
            <table class="w-full bg-white border-collapse">
                <thead class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white">
                    <tr>
                        <th class="p-4 text-left">Position</th>
                        <th class="p-4 text-left">Base Salary</th>
                        <th class="p-4 text-left">Department</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="p-4">{{ $position->title }}</td>
                            <td class="p-4">{{ number_format($position->base_salary, 2) }}</td>
                            <td class="p-4">{{ $position->department->name ?? 'N/A' }}</td>
                            <td class="p-4 flex items-center">
                                <a href="{{ route('position.edit', $position->id) }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                </a>
                                <form action="{{ route('position.destroy', $position->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Departments Table with Gradients -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Departments</h2>
        <div class="overflow-hidden rounded-xl shadow-lg">
            <table class="w-full bg-white border-collapse">
                <thead class="bg-gradient-to-r from-purple-500 to-pink-600 text-white">
                    <tr>
                        <th class="p-4 text-left">Department Name</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="p-4">{{ $department->name }}</td>
                            <td class="p-4 flex items-center">
                                <a href="{{ route('department.edit', $department->id) }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                </a>
                                <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
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
@endsection
