@extends('hr1.layouts.app')

@section('content')
<section class="container mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Employee Management</h2>
        <a href="{{ route('employees.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add New Employee</a>
    </div>

    <!-- Search Employees -->
    <div class="mb-6">
        <form action="{{ route('employees.index') }}" method="GET" class="flex">
            <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Search employees..." class="w-full p-2 border border-gray-300 rounded-l-lg focus:ring focus:ring-blue-200" id="employeeSearch">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700">Search</button>
        </form>
    </div>

    <!-- Employee Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">First Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Last Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Position</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Hire Date</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($employees as $employee)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $employee->first_name }}</td>
                        <td class="px-6 py-4">{{ $employee->last_name }}</td>
                        <td class="px-6 py-4">{{ $employee->position->position_name }}</td>
                        <td class="px-6 py-4">{{ $employee->hire_date }}</td>
                        <td class="px-6 py-4">{{ ucfirst($employee->status) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('employees.edit', $employee->employee_id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->employee_id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
