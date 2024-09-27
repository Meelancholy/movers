@extends('hr1.layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold mb-6">Add New Employee</h2>

            <form action="{{ route('employees.store') }}" method="POST">
                @csrf

                <!-- First Name -->
                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200" placeholder="First Name" required />
                </div>

                <!-- Last Name -->
                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200" placeholder="Last Name" required />
                </div>

                <!-- Position -->
                <div class="mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700">Position</label>
                    <select name="position_id" id="position_id" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200">
                        @foreach ($positions as $position)
                            <option value="{{ $position->position_id }}">{{ $position->position_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hire Date -->
                <div class="mb-4">
                    <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                    <input type="date" name="hire_date" id="hire_date" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200" required />
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200" required>
                        <option value="active">Active</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>

                <!-- Contact Info -->
                <div class="mb-4">
                    <label for="contact_info" class="block text-sm font-medium text-gray-700">Contact Info</label>
                    <input type="text" name="contact_info" id="contact_info" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200" placeholder="Contact Info" required />
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-green-200" placeholder="Address" required />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Add</button>
                </div>
            </form>
        </div>
    </section>
@endsection
