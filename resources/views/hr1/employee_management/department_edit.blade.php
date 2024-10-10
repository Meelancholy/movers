@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto">
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
    <form action="{{ route('department.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Department Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" class="w-full border-gray-300 rounded mt-1 p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-150 ease-in-out">Update Department</button>
            <a href="{{ route('employee.dashboard') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-150 ease-in-out">Cancel</a>
        </div>
    </form>
</div>
@endsection
