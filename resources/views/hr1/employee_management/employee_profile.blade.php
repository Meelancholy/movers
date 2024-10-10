@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Employee Profile</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="mb-4 border-b pb-4">
            <label class="font-semibold text-gray-700">Name:</label>
            <p class="text-gray-600">{{ $employee->last_name }}, {{ $employee->first_name }}</p>
        </div>
        <div class="mb-4 border-b pb-4">
            <label class="font-semibold text-gray-700">Department:</label>
            <p class="text-gray-600">{{ $employee->department->name ?? 'N/A' }}</p>
        </div>
        <div class="mb-4 border-b pb-4">
            <label class="font-semibold text-gray-700">Position:</label>
            <p class="text-gray-600">{{ $employee->position->title ?? 'N/A' }}</p>
        </div>
        <div class="mb-4 border-b pb-4">
            <label class="font-semibold text-gray-700">Status:</label>
            <p class="text-gray-600">{{ $employee->status }}</p>
        </div>
        <div class="mb-4 border-b pb-4">
            <label class="font-semibold text-gray-700">Contact:</label>
            <p class="text-gray-600">{{ $employee->contact ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('employee.list') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Back to Employee List</a>
    </div>
</div>
@endsection
