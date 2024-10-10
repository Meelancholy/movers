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
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2 rounded-full shadow-lg transition transform hover:scale-105 mt-6">
            Add Position
        </button>
    </form>
</div>
@endsection
