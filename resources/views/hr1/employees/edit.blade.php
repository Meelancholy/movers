@extends('hr1.layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold mb-6">Edit Employee</h2>

            <form action="{{ route('employees.update', $employee->employee_id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- First Name -->
                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="{{ $employee->first_name }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required />
                </div>

                <!-- Last Name -->
                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="{{ $employee->last_name }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required />
                </div>

                <!-- Position -->
                <div class="mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700">Position</label>
                    <select name="position_id" id="position_id" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>
                        @foreach($positions as $position)
                            <option value="{{ $position->position_id }}" {{ $position->position_id == $employee->position_id ? 'selected' : '' }}>{{ $position->position_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hire Date -->
                <div class="mb-4">
                    <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                    <input type="date" name="hire_date" id="hire_date" value="{{ $employee->hire_date }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required />
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>
                        <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>

                <!-- Contact Info -->
                <div class="mb-4">
                    <label for="contact_info" class="block text-sm font-medium text-gray-700">Contact Info</label>
                    <input type="text" name="contact_info" id="contact_info" value="{{ $employee->contact_info }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required />
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="{{ $employee->address }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required />
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update</button>
                    <a href="{{ route('employees.index') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
