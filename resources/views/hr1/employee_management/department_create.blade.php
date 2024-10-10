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
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2 rounded-full shadow-lg transition transform hover:scale-105 mt-6">
            Add Department
        </button>
    </form>
</div>
@endsection
