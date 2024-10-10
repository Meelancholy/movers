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
    <div class="mt-6">
        <a href="{{ route('employee.list') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 rounded-full shadow-lg hover:bg-blue-600 transition transform hover:scale-105 duration-200">
            Back to Employee List
        </a>
    </div>
</div>
@endsection
