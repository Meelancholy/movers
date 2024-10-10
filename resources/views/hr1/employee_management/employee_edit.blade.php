@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-3xl font-bold mb-6">Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <form method="POST" action="{{ route('employee.update', $employee->id) }}" class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" class="form-input w-full border border-gray-300 rounded-md p-2" value="{{ $employee->first_name }} {{ $employee->last_name }}" required>
        </div>

        <div class="mb-4">
            <label for="department_id" class="block text-gray-700 font-semibold mb-2">Department</label>
            <select name="department_id" class="form-select w-full border border-gray-300 rounded-md p-2" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="position_id" class="block text-gray-700 font-semibold mb-2">Position</label>
            <select name="position_id" class="form-select w-full border border-gray-300 rounded-md p-2" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>{{ $position->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status" class="form-select w-full border border-gray-300 rounded-md p-2" required>
                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="on leave" {{ $employee->status == 'on leave' ? 'selected' : '' }}>On Leave</option>
                <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="contact" class="block text-gray-700 font-semibold mb-2">Contact</label>
            <input type="text" name="contact" class="form-input w-full border border-gray-300 rounded-md p-2" value="{{ $employee->contact }}" placeholder="Optional">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-200">Update Employee</button>
    </form>
</div>
@endsection
