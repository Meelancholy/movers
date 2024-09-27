@extends('hr1.layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-10">
        <div>

            <!-- Position Management -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold">Position Management</h2>
                    <a href="{{ route('positions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Position</a>
                </div>

                <!-- Search Positions -->
                <div class="mb-6">
                    <form action="{{ route('positions.index') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Search Positions..." class="w-full p-2 border border-gray-300 rounded-l-lg focus:ring focus:ring-blue-200" id="positionSearch">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700">Search</button>
                    </form>
                </div>

                <!-- Position Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <table class="min-w-full table-auto" id="positionTable">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium">Position Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Department</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Base Salary</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($positions as $position)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-4">{{ $position->position_name }}</td>
                                    <td class="px-6 py-4">{{ $position->department->department_name }}</td>
                                    <td class="px-6 py-4">${{ number_format($position->base_salary, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('positions.edit', $position->position_id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
                                        <form action="{{ route('positions.destroy', $position->position_id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
