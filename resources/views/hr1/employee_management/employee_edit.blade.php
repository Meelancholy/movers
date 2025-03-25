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
            <label for="first_name" class="block text-lg font-semibold mb-2">First Name</label>
            <input type="text" name="first_name" id="first_name"
                   class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                   value="{{ $employee->first_name }}">
            @error('first_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="last_name" class="block text-lg font-semibold mb-2">Last Name</label>
            <input type="text" name="last_name" id="last_name"
                   class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                   value="{{ $employee->last_name }}">
            @error('last_name')
                   <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <!-- Status Selection -->
        <div>
            <label for="status" class="block text-lg font-semibold mb-2">Status</label>
            <select name="status" id="status"
                    class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="on leave" {{ $employee->status == 'on leave' ? 'selected' : '' }}>On Leave</option>
                <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
            @error('status')
                   <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contact Input -->
        <div>
            <label for="contact" class="block text-lg font-semibold mb-2">Contact</label>
            <input type="text" name="contact" id="contact"
                   class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                   value="{{ $employee->contact }}" placeholder="Optional">
            @error('contact')
                   <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <!-- Submit Button -->
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Update Employee
            </button>
            <a href="{{ route('employee.list') }}" class="bg-gray-300 hover:bg-gray-4   00 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                Back to Employee list
            </a>
        </div>
    </form>
</div>
@endsection
