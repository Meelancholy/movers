@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded p-10 container mx-auto">
    <h1 class="text-2xl font-bold">Employee Dashboard</h1>
    <div class="mt-6 grid grid-cols-3 gap-4">
        <div class="bg-blue-200 p-4 rounded">
            <h2 class="font-semibold">Total Employees</h2>
            <p>{{ $totalEmployees }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded">
            <h2 class="font-semibold">Active Employees</h2>
            <p>{{ $activeEmployees }}</p>
        </div>
        <div class="bg-red-100 p-4 rounded">
            <h2 class="font-semibold">Inactive Employees</h2>
            <p>{{ $inactiveEmployees }}</p>
        </div>
    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('employee.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded">Add New Employee</a>
        <a href="{{ route('employee.list') }}" class="bg-blue-500 text-white px-6 py-2 rounded">View All Employees</a>
        <a href="{{ route('department.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded">Add New Department</a>
        <a href="{{ route('position.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded">Add New Position</a>
    </div>

    <div class="mt-6">
        <h2 class="text-lg font-bold mb-4">Employees by Department</h2>
        <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
            @foreach($departments as $department)
                <li class="flex justify-between items-center px-4 py-2 hover:bg-gray-100 transition duration-200">
                    <span class="text-gray-800 font-medium">{{ $department->name }}</span>
                    <span class="text-gray-500">{{ $department->employees_count }}</span>
                </li>
            @endforeach
        </ul>
    </div>

<!-- Positions Table -->
<h2 class="text-lg mt-8 font-bold">Positions</h2>
<table class="min-w-full border-collapse border border-gray-300 mt-4">
    <thead class="bg-blue-600 text-white">
        <tr>
            <th class="border border-gray-300 p-2">Position</th>
            <th class="border border-gray-300 p-2">Base Salary</th>
            <th class="border border-gray-300 p-2">Department</th>
            <th class="border border-gray-300 p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($positions as $position)
            <tr class="hover:bg-gray-100 transition duration-200">
                <td class="border border-gray-300 p-2">{{ $position->title }}</td>
                <td class="border border-gray-300 p-2">{{ number_format($position->base_salary, 2) }}</td>
                <td class="border border-gray-300 p-2">{{ $position->department->name ?? 'N/A' }}</td>
                <td class="border border-gray-300 p-2 flex space-x-2">
                    <a href="{{ route('position.edit', $position->id) }}" class="text-blue-500 hover:text-blue-700 transition">Edit</a>
                    <form action="{{ route('position.destroy', $position->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Departments Table -->
<h2 class="text-lg mt-8 font-bold">Departments</h2>
<table class="min-w-full border-collapse border border-gray-300 mt-4">
    <thead class="bg-blue-600 text-white">
        <tr>
            <th class="border border-gray-300 p-2">Name</th>
            <th class="border border-gray-300 p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departments as $department)
            <tr class="hover:bg-gray-100 transition duration-200">
                <td class="border border-gray-300 p-2">{{ $department->name }}</td>
                <td class="border border-gray-300 p-2 flex space-x-2">
                    <a href="{{ route('department.edit', $department->id) }}" class="text-blue-500 hover:text-blue-700 transition">Edit</a>
                    <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection
