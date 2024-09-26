@extends('hr1.layouts.app')

@section('content')
<section class="container mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Departments</h2>
        <a href="{{ route('departments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Department</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Department ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Department Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($departments as $department)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $department->department_id }}</td>
                        <td class="px-6 py-4">{{ $department->department_name }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('departments.edit', $department->department_id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('departments.destroy', $department->department_id) }}" method="POST" class="inline-block">
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
</section>
@endsection
