@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Add New Department</h1>

    <form action="{{ route('department.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Department Name -->
        <div>
            <label for="name" class="block text-lg font-semibold mb-2">Department Name</label>
            <input type="text" name="name" id="name" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Add Department
            </button>
            <a href="{{ route('employee.dashboard') }}" class="bg-gray-300 hover:bg-gray-4 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                Back to Employee Dashboard
            </a>
        </div>
    </form>
</div>
@endsection
