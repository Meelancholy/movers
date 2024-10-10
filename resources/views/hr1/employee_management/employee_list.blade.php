@extends('hr1.layouts.app')

@section('content')
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mt-5">Employee List</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('employee.list') }}" class="mt-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <select name="department_id" class="form-select border border-gray-300 rounded-full px-4 py-2">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>

                <select name="position_id" class="form-select border border-gray-300 rounded-full px-4 py-2">
                    <option value="">All Positions</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                    @endforeach
                </select>

                <select name="status" class="form-select border border-gray-300 rounded-full px-4 py-2">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="on leave">On Leave</option>
                    <option value="terminated">Terminated</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-full transition transform hover:scale-105 hover:bg-blue-700 shadow-lg">
                    Filter
                </button>
            </div>
        </form>

        <!-- Employee Table -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white border border-gray-300">
                    <tr>
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Department</th>
                        <th class="px-4 py-2">Position</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr class="hover:bg-gray-100 transition duration-200 ">
                            <td class="px-4 py-2">{{ $employee->id }}</td>
                            <td class="px-4 py-2">{{ $employee->last_name }}, {{ $employee->first_name }}</td>
                            <td class="px-4 py-2">{{ $employee->department->name }}</td>
                            <td class="px-4 py-2">{{ $employee->position->title }}</td>
                            <td class="px-4 py-2">{{ $employee->status }}</td>
                            <td class="px-4 py-2 flex space-x-4">
                                <!-- Styled Buttons for Actions -->
                                <a href="{{ route('employee.profile', $employee->id) }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                </a>
                                <a href="{{ route('employee.edit', $employee->id) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                </a>
                                <form method="POST" action="{{ route('employee.delete', $employee->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $employees->links() }}
        </div>
    </div>
@endsection
