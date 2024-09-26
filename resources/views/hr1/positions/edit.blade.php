@extends('hr1.layouts.app')

@section('content')
<section class="container mx-auto px-4 py-10">
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-3xl font-bold mb-4">Edit Position</h2>

        <form action="{{ route('positions.update', $position->position_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Position Name -->
            <div>
                <label class="block text-gray-700">Position Name</label>
                <input type="text" name="position_name" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $position->position_name }}" required>
            </div>

            <!-- Department -->
            <div>
                <label class="block text-gray-700">Department</label>
                <select name="department_id" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    @foreach($departments as $department)
                        <option value="{{ $department->department_id }}" {{ $position->department_id == $department->department_id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Base Salary -->
            <div>
                <label class="block text-gray-700">Base Salary</label>
                <input type="number" name="base_salary" step="0.01" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $position->base_salary }}" required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
            </div>
        </form>
    </div>
</section>
@endsection
