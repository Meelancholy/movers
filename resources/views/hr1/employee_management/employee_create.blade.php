@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Add New Employee</h1>

    <form method="POST" action="{{ route('employee.store') }}" class="space-y-6">
        @csrf

        <!-- First Name -->
        <div>
            <label for="first_name" class="block text-lg font-semibold mb-2">First Name</label>
            <input type="text" name="first_name" id="first_name" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Last Name -->
        <div>
            <label for="last_name" class="block text-lg font-semibold mb-2">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-lg font-semibold mb-2">Email</label>
            <input type="email" name="email" id="email" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Department -->
        <div>
            <label for="department_id" class="block text-lg font-semibold mb-2">Department</label>
            <select name="department_id" id="department_id" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Position -->
        <div>
            <label for="position_id" class="block text-lg font-semibold mb-2">Position</label>
            <select name="position_id" id="position_id" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-lg font-semibold mb-2">Status</label>
            <select name="status" id="status" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="on leave">On Leave</option>
                <option value="terminated">Terminated</option>
            </select>
        </div>

        <!-- Contact (Optional) -->
        <div>
            <label for="contact" class="block text-lg font-semibold mb-2">Contact</label>
            <input type="text" name="contact" id="contact" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" placeholder="Optional">
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Add Employee
            </button>
            <a href="{{ route('employee.list') }}" class="bg-gray-300 hover:bg-gray-4   00 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                Back to Employee list
            </a>
        </div>
    </form>
</div>
@endsection
