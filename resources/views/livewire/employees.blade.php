@extends('hr1.layouts.app')

@section('content')
<body class="bg-gray-100 text-gray-800">

    <!-- Main Content -->
    <section class="container mx-auto px-4 py-10">
        <!-- Heading and Add Employee Button -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Employee List</h2>
            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Employee</a>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <input type="text" placeholder="Search employees..." class="border border-gray-300 p-2 w-full rounded-lg focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <!-- Employee Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">First Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Last Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Position</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Department</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Hire Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">1</td>
                        <td class="px-6 py-4">John</td>
                        <td class="px-6 py-4">Doe</td>
                        <td class="px-6 py-4">Driver</td>
                        <td class="px-6 py-4">Transport</td>
                        <td class="px-6 py-4">2023-01-05</td>
                        <td class="px-6 py-4 text-green-500">Active</td>
                        <td class="px-6 py-4">
                            <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                            <a href="#" class="text-red-600 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <!-- More employee rows can go here -->
                </tbody>
            </table>
        </div>
    </section>
@endsection
