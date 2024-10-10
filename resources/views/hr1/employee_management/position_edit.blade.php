@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-3xl font-bold mb-6">Edit Position</h1>

    <form action="{{ route('position.update', $position->id) }}" method="POST" class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Position Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $position->title) }}" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="base_salary" class="block text-gray-700 font-semibold mb-2">Base Salary</label>
            <input type="number" name="base_salary" id="base_salary" value="{{ old('base_salary', $position->base_salary) }}" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="department_id" class="block text-gray-700 font-semibold mb-2">Department</label>
            <select name="department_id" id="department_id" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select a Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $department->id === $position->department_id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded mt-4 hover:bg-blue-600 transition duration-200">Update Position</button>
    </form>
</div>
@endsection
