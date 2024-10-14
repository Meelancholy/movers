<div class="container min-w-full bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Employee List</h1>
        <a href="{{ route('employee.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
            Add New Employee
        </a>
    </div>

    <!-- Filter and Search Form -->
    <form method="GET" class="mb-8" wire:submit.prevent="filterEmployees">
        <div class="flex items-center justify-between w-full">
            <!-- Left-aligned Filters -->
            <div class="flex">
                <input type="text" wire:model="search" placeholder="Search by name or id..." class="form-input border border-gray-300 rounded-l-full pl-4 pr-24 py-2" />

                <select wire:model="department_id" class="form-select border border-gray-300 px-6 py-2">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>

                <select wire:model="position_id" class="form-select border border-gray-300 px-6 py-2">
                    <option value="">All Positions</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                    @endforeach
                </select>

                <select wire:model="status" class="form-select border border-gray-300 rounded-r-full px-6 py-2">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="on leave">On Leave</option>
                    <option value="terminated">Terminated</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold ml-4 px-10 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                    Search
                </button>
            </div>
        </div>
    </form>

    <!-- Employee Table -->
    <div class="overflow-x-auto rounded-lg shadow-lg mb-8">
        <table class="min-w-full bg-white border-collapse table-auto">
            <thead class="bg-blue-100 text-gray-800">
                <tr>
                    <th class="p-4 text-left">Id</th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-center">Department</th>
                    <th class="p-4 text-center">Position</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr class="hover:bg-blue-50 transition duration-300 ease-in-out">
                        <td class="p-4 text-gray-800">{{ $employee->id }}</td>
                        <td class="p-4 text-gray-800"><strong>{{ $employee->last_name }}, {{ $employee->first_name }}</strong></td>
                        <td class="p-4 text-center text-gray-800">{{ $employee->department->name }}</td>
                        <td class="p-4 text-center text-gray-800">{{ $employee->position->title }}</td>
                        <td class="p-4 text-center"><strong>
                            <span class="{{
                                $employee->status === 'active' ? 'text-green-600' :
                                ($employee->status === 'inactive' ? 'text-red-600' :
                                ($employee->status === 'on leave' ? 'text-yellow-600' :
                                ($employee->status === 'terminated' ? 'text-gray-600' : 'text-gray-800'))) }}">
                                {{ ucfirst($employee->status) }}
                            </span></strong>
                        </td>
                        <td class="p-4 flex justify-center space-x-4">
                            <a href="{{ route('employee.profile', $employee->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-search"><circle cx="10" cy="7" r="4"/><path d="M10.3 15H7a4 4 0 0 0-4 4v2"/><circle cx="17" cy="17" r="3"/><path d="m21 21-1.9-1.9"/></svg>
                            </a>
                            <a href="{{ route('employee.edit', $employee->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 21a8 8 0 0 1 10.821-7.487"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="8" r="5"/></svg>
                            </a>
                            <form method="POST" action="{{ route('employee.delete', $employee->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 21a8 8 0 0 1 11.873-7"/><circle cx="10" cy="8" r="5"/><path d="m17 17 5 5"/><path d="m22 17-5 5"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $employees->links() }}
    </div>
</div>
