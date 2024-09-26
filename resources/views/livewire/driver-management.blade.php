@extends('hr1.layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Vehicle Management -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold">Vehicle Management</h2>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Vehicle</a>
                </div>

                <!-- Search Vehicles -->
                <div class="mb-6">
                    <input type="text" placeholder="Search Vehicles..." class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" id="vehicleSearch">
                </div>

                <!-- Vehicle Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <table class="min-w-full table-auto" id="vehicleTable">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium">Vehicle ID</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Vehicle Number</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Model</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Year</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-4">1</td>
                                <td class="px-6 py-4">ABC-1234</td>
                                <td class="px-6 py-4">Toyota Corolla</td>
                                <td class="px-6 py-4">2020</td>
                                <td class="px-6 py-4">Active</td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                                </td>
                            </tr>
                            <!-- More vehicle rows can go here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Driver Assignment -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold">Driver Assignment</h2>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Assign Driver</a>
                </div>

                <!-- Search Driver Assignments -->
                <div class="mb-6">
                    <input type="text" placeholder="Search Driver Assignments..." class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" id="assignmentSearch">
                </div>

                <!-- Driver Assignment Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <table class="min-w-full table-auto" id="assignmentTable">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium">Assignment ID</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Driver Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Vehicle</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Assignment Start</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Assignment End</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-4">1</td>
                                <td class="px-6 py-4">John Doe</td>
                                <td class="px-6 py-4">ABC-1234</td>
                                <td class="px-6 py-4">2024-09-01</td>
                                <td class="px-6 py-4">2024-09-10</td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                                </td>
                            </tr>
                            <!-- More assignment rows can go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
