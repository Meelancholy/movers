@extends('hr1.layouts.app')

@section('content')
    <div class="container mx-auto bg-white p-6 rounded-lg">
        <h1 class="text-2xl font-bold mt-5">Employee List</h1>
        <form method="GET" action="{{ route('employee.list') }}" class="mt-4">
            <div class="flex items-center gap-2">
                <select name="department_id" class="form-select border border-gray-300 rounded px-4 py-2">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <select name="position_id" class="form-select border border-gray-300 rounded px-4 py-2">
                    <option value="">All Positions</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-select border border-gray-300 rounded px-4 py-2">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="on leave">On Leave</option>
                    <option value="terminated">Terminated</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Filter</button>
            </div>
        </form>

        <table class="mt-4 min-w-full border-collapse border border-gray-300">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Id</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Department</th>
                    <th class="border border-gray-300 px-4 py-2">Position</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border border-gray-300 px-4 py-2">{{ $employee->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $employee->last_name }}, {{ $employee->first_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $employee->department->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $employee->position->title }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $employee->status }}</td>
                        <td class="border border-gray-300 px-4 py-2 flex space-x-2">
                            <a href="{{ route('employee.profile', $employee->id) }}" class="text-blue-500 hover:text-blue-700 transition">View</a>
                            <a href="{{ route('employee.edit', $employee->id) }}" class="text-yellow-500 hover:text-yellow-700 transition">Edit</a>
                            <form method="POST" action="{{ route('employee.delete', $employee->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $employees->links() }} <!-- Pagination links -->
    </div>
@endsection
