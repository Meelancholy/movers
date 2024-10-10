@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-6 bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6">Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <!-- Edit Employee Form -->
    <form method="POST" action="{{ route('employee.update', $employee->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Employee Name -->
        <div>
            <label for="name" class="block text-lg font-semibold mb-2">Name</label>
            <input type="text" name="name" id="name"
                   class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                   value="{{ $employee->first_name }} {{ $employee->last_name }}" required>
        </div>

        <!-- Department Selection -->
        <div>
            <label for="department_id" class="block text-lg font-semibold mb-2">Department</label>
            <select name="department_id" id="department_id"
                    class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Position Selection -->
        <div>
            <label for="position_id" class="block text-lg font-semibold mb-2">Position</label>
            <select name="position_id" id="position_id"
                    class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>{{ $position->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status Selection -->
        <div>
            <label for="status" class="block text-lg font-semibold mb-2">Status</label>
            <select name="status" id="status"
                    class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="on leave" {{ $employee->status == 'on leave' ? 'selected' : '' }}>On Leave</option>
                <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
        </div>

        <!-- Contact Input -->
        <div>
            <label for="contact" class="block text-lg font-semibold mb-2">Contact</label>
            <input type="text" name="contact" id="contact"
                   class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                   value="{{ $employee->contact }}" placeholder="Optional">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2 rounded-full shadow-lg transition transform hover:scale-105">
            Update Employee
        </button>
    </form>
</div>
@endsection
