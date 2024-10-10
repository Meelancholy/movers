@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Edit Department</h1>

    <!-- Display validation errors if any -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Department Form -->
    <form action="{{ route('department.update', $department->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Department Name -->
        <div>
            <label for="name" class="block text-lg font-semibold mb-2">Department Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}"
                   class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2 rounded-full shadow-lg transition transform hover:scale-105">
                Update Department
            </button>
            <a href="{{ route('employee.dashboard') }}" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-full shadow-lg transition transform hover:scale-105">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
