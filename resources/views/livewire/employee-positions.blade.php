@extends('hr1.layouts.app')

@section('content')
<div class="bg-gray-100 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Employee Positions</h2>

    <div class="mb-4">
        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add New Position
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Position Title</th>
                    <th class="py-2 px-4 border">Department</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4 border">Software Engineer</td>
                    <td class="py-2 px-4 border">IT Department</td>
                    <td class="py-2 px-4 border">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-red-500 hover:underline ml-2">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border">HR Manager</td>
                    <td class="py-2 px-4 border">HR Department</td>
                    <td class="py-2 px-4 border">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-red-500 hover:underline ml-2">Delete</a>
                    </td>
                </tr>
                <!-- Add more positions as needed -->
            </tbody>
        </table>
    </div>
</div>
@endsection
