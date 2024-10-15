@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Add New Position</h1>

    <form action="{{ route('position.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Position Title -->
        <div>
            <label for="title" class="block text-lg font-semibold mb-2">Position Title</label>
            <input type="text" name="title" id="title" required class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
        </div>

        <!-- Base Salary -->
        <div>
            <label for="base_salary" class="block text-lg font-semibold mb-2">Base Salary</label>
            <input type="number" name="base_salary" id="base_salary" required class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
        </div>

        <!-- Department Selection -->
        <div>
            <label for="department_id" class="block text-lg font-semibold mb-2">Department</label>
            <select name="department_id" id="department_id" required class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
                <option value="">Select a Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Add Position
            </button>
            <a href="{{ route('employee.dashboard') }}" class="bg-gray-300 hover:bg-gray-4 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                Back to Employee Dashboard
            </a>
        </div>
    </form>
</div>
@endsection
