@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Employee Profile</h1>

    <!-- Profile Information Card -->
    <div class="bg-white shadow-lg rounded-lg p-6 space-y-4">
        <!-- Name -->
        <div class="border-b pb-4">
            <label class="font-semibold text-lg text-gray-700">Name:</label>
            <p class="text-gray-600">{{ $employee->last_name }}, {{ $employee->first_name }}</p>
        </div>

        <!-- Department -->
        <div class="border-b pb-4">
            <label class="font-semibold text-lg text-gray-700">Department:</label>
            <p class="text-gray-600">{{ $employee->department->name ?? 'N/A' }}</p>
        </div>

        <!-- Position -->
        <div class="border-b pb-4">
            <label class="font-semibold text-lg text-gray-700">Position:</label>
            <p class="text-gray-600">{{ $employee->position->title ?? 'N/A' }}</p>
        </div>

        <!-- Status -->
        <div class="border-b pb-4">
            <label class="font-semibold text-lg text-gray-700">Status:</label>
            <p class="text-gray-600">{{ $employee->status }}</p>
        </div>

        <!-- Contact -->
        <div class="border-b pb-4">
            <label class="font-semibold text-lg text-gray-700">Contact:</label>
            <p class="text-gray-600">{{ $employee->contact ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex justify-end space-x-4 mt-6">
        <a href="{{ route('employee.edit', $employee->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full transition transform hover:scale-105">
            Edit Employee
        </a>
        <a href="{{ route('employee.list') }}" class="bg-gray-300 hover:bg-gray-4   00 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
            Back to Employee list
        </a>
    </div>
</div>
@endsection
