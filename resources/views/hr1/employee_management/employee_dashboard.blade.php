@extends('hr1.layouts.app')

@section('content')
<div class="p-10 container min-w-full bg-white rounded-lg shadow-md">
    <!-- Title Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Employee Dashboard</h1>

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
        <a href="{{ route('employee.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Employee
        </a>
        <a href="{{ route('employee.list') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            View All Employees
        </a>
        <a href="{{ route('position.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Position
        </a>
        <a href="{{ route('department.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Department
        </a>
    </div>

    <!-- Flex container for Department and Positions Tables -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Department Table -->
        <div class="lg:w-1/2 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Departments</h2>
            <div class="overflow-hidden rounded-xl shadow-lg">
                <table class="w-full bg-white border-collapse table-auto">
                    <thead class="bg-blue-100 text-gray-800">
                        <tr>
                            <th class="p-4 text-left">Department Name</th>
                            <th class="p-4 text-center">Number of Employees</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $department)
                            <tr class="hover:bg-blue-50 transition duration-300 ease-in-out">
                                <td class="p-4 text-gray-800">{{ $department->name }}</td>
                                <td class="p-4 text-center text-gray-800">{{ $department->employees_count }}</td>
                                <td class="p-4 flex items-center justify-center">
                                    <a href="{{ route('department.edit', $department->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="m18 5-2.414-2.414A2 2 0 0 0 14.172 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2"/><path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><path d="M8 18h1"/></svg>
                                    </a>
                                    <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="m14.5 12.5-5 5"/><path d="m9.5 12.5 5 5"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Positions Table -->
        <div class="lg:w-1/2 mb-8">
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
                                <td class="p-4 text-gray-800">{{ $position->title }}</td>
                                <td class="p-4 text-center text-gray-800">{{ $position->employees_count }}</td>
                                <td class="p-4 hidden md:table-cell text-gray-800">{{ number_format($position->base_salary, 2) }}</td>
                                <td class="p-4 flex items-center justify-center">
                                    <a href="{{ route('position.edit', $position->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="m18 5-2.414-2.414A2 2 0 0 0 14.172 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2"/><path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><path d="M8 18h1"/></svg>
                                    </a>
                                    <form action="{{ route('position.destroy', $position->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full transition transform hover:scale-105 shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="m14.5 12.5-5 5"/><path d="m9.5 12.5 5 5"/></svg>
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
@endsection
