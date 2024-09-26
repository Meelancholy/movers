@extends('hr1.layouts.app')

@section('content')
<section class="container mx-auto px-4 py-10">
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-3xl font-bold mb-4">Edit Department</h2>

        <form action="{{ route('departments.update', $department->department_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Department Name -->
            <div>
                <label class="block text-gray-700">Department Name</label>
                <input type="text" name="department_name" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $department->department_name }}" required>
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update</button>
                <a href="{{ route('departments.index') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection
