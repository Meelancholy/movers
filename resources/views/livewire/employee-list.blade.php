<div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-12">
    <div x-data="{ selectedTab: 'employeeList' }" class="w-full">
        <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()" class="flex gap-2 overflow-x-auto border-b border-neutral-300" role="tablist" aria-label="tab options">
            <h1 class="text-3xl font-bold text-gray-800 mr-auto">Employee Management</h1>
            <button @click="selectedTab = 'employeeList'" :aria-selected="selectedTab === 'employeeList'" :tabindex="selectedTab === 'employeeList' ? '0' : '-1'" :class="selectedTab === 'employeeList' ? 'font-bold text-black border-b-2 border-black' : 'text-neutral-600 font-medium'" class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelEmployeeList" >Employee List</button>
            <button @click="selectedTab = 'likes'" :aria-selected="selectedTab === 'likes'" :tabindex="selectedTab === 'likes' ? '0' : '-1'" :class="selectedTab === 'likes' ? 'font-bold text-black border-b-2 border-black' : 'text-neutral-600 font-medium'" class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelLikes" >Organizational Chart</button>
        </div>
        @if(session('success'))
            <div class="mb-5 relative w-full overflow-hidden rounded-md border border-green-500 bg-white text-neutral-600 text-black" role="alert">
                <div class="flex w-full items-center gap-2 bg-green-500/10 p-4">
                    <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-green-500">Success</h3>
                        <p class="text-xs font-medium sm:text-sm">{{ session('success') }}</p>
                    </div>
                    <button class="ml-auto" aria-label="dismiss alert">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="#000000" fill="none" stroke-width="2.5" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        <div class="px-2 py-4 text-neutral-600">
            <div x-show="selectedTab === 'employeeList'" id="tabpanelEmployeeList" role="tabpanel" aria-label="employeeList">
                <div class="flex">
                    <!-- Filter and Search Form -->
                    <form method="GET" class="mb-8 mr-auto" wire:submit.prevent="filterEmployees">
                        <div class="flex items-center justify-between w-full">
                            <!-- Left-aligned Filters -->
                            <div class="flex">
                                <div class="flex items-center border border-gray-300 rounded-l-full py-2 pl-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                    <input type="text" wire:model="search" placeholder="Search by name or id..." class="form-input focus:outline-none w-auto" />
                                </div>
                                <select wire:model="department_id" class="form-select border border-gray-300 px-6 py-2">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>

                                <select wire:model="position_id" class="form-select border border-gray-300 px-6 py-2 ">
                                    <option value="">All Positions</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>

                                <select wire:model="status" class="form-select border border-gray-300 px-6 py-2">
                                    <option value="">All Statuses</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="on leave">On Leave</option>
                                    <option value="terminated">Terminated</option>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-10 py-2 rounded-r-full transition shadow-lg">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                    @livewire('employee-create')
                </div>

                <!-- Employee Table -->
                <div x-data="{ modalIsOpen: false, selectedEmployeeId: null }" class="overflow-x-auto rounded-lg shadow-lg mb-8 md:overflow-x-visible">
                    <table class="min-w-full bg-white border-collapse table-auto md:w-full">
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
                            @if($employees->isEmpty())
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-800">
                                        <strong>No employees found</strong>
                                    </td>
                                </tr>
                            @else
                                @foreach($employees as $employee)
                                    <tr class="hover:bg-blue-50 transition duration-300 ease-in-out">
                                        <td class="p-4 text-gray-800">{{ $employee->id }}</td>
                                        <td class="p-4 text-gray-800"><strong>{{ $employee->last_name }}, {{ $employee->first_name }}</strong></td>
                                        <td class="p-4 text-center text-gray-800">{{ $employee->department->name }}</td>
                                        <td class="p-4 text-center text-gray-800">{{ $employee->position->name }}</td>
                                        <td class="p-4 text-center">
                                            {{-- Badge based on status --}}
                                            @if($employee->status === 'active')
                                                <span class="w-fit inline-flex overflow-hidden rounded-md border border-green-500 bg-white text-xs font-medium text-green-500">
                                                    <span class="px-2 py-1 bg-green-500/10">Active</span>
                                                </span>
                                            @elseif($employee->status === 'inactive')
                                                <span class="w-fit inline-flex overflow-hidden rounded-md border border-red-500 bg-white text-xs font-medium text-red-500">
                                                    <span class="px-2 py-1 bg-red-500/10">Inactive</span>
                                                </span>
                                            @elseif($employee->status === 'on leave')
                                                <span class="w-fit inline-flex overflow-hidden rounded-md border border-amber-500 bg-white text-xs font-medium text-amber-500">
                                                    <span class="px-2 py-1 bg-amber-500/10">On Leave</span>
                                                </span>
                                            @elseif($employee->status === 'terminated')
                                                <span class="w-fit inline-flex overflow-hidden rounded-md border border-neutral-800 bg-white text-xs font-medium text-neutral-800">
                                                    <span class="px-2 py-1 bg-neutral-800/10">Terminated</span>
                                                </span>
                                            @endif
                                        </td>


                                        <td class="p-4 flex justify-center space-x-4">
                                            <a href="{{ route('employee.profile', $employee->id) }}" class="bg-green-400 hover:bg-green-500 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-search"><circle cx="10" cy="7" r="4"/><path d="M10.3 15H7a4 4 0 0 0-4 4v2"/><circle cx="17" cy="17" r="3"/><path d="m21 21-1.9-1.9"/></svg>
                                            </a>
                                            <a href="{{ route('employee.edit', $employee->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 21a8 8 0 0 1 10.821-7.487"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="8" r="5"/></svg>
                                            </a>
                                            <form method="POST" action="{{ route('employee.delete', $employee->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 21a8 8 0 0 1 11.873-7"/><circle cx="10" cy="8" r="5"/><path d="m17 17 5 5"/><path d="m22 17-5 5"/></svg>
                                                </button>
                                            </form>
                                            <button @click="modalIsOpen = true; selectedEmployeeId = {{ $employee->id }}" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="7" r="4"/><path d="M10.3 15H7a4 4 0 0 0-4 4v2"/><circle cx="17" cy="17" r="3"/><path d="m21 21-1.9-1.9"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div x-show="modalIsOpen" x-cloak x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" @keydown.esc.window="modalIsOpen = false" @click.self="modalIsOpen = false" class="fixed inset-0 z-30 flex items-center justify-center bg-black/20 p-4 pb-8 backdrop-blur-md">
                        <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="max-w-lg w-full p-6 bg-white rounded-lg shadow-lg">
                            <div class="flex items-center justify-between border-b pb-4 mb-4">
                                <h3 class="text-xl font-semibold">Employee Details</h3>
                                <button @click="modalIsOpen = false" aria-label="close modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal Content: Display Employee Information -->
                            <div x-show="selectedEmployeeId" class="space-y-4">
                                <p><strong>Employee ID:</strong> <span x-text="selectedEmployeeId"></span></p>
                                <!-- Optionally, fetch and display additional details for the selected employee -->
                                <p><strong>Name:</strong> <span x-text="'Employee Name: ' + selectedEmployeeId"></span></p>
                                <!-- You can load the employee's other details dynamically based on selectedEmployeeId -->
                            </div>
                            <div class="mt-4 flex justify-end space-x-4">
                                <button @click="modalIsOpen = false" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-full">Close</button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $employees->links() }}
                </div>
            </div>
            <div x-show="selectedTab === 'likes'" id="tabpanelLikes" role="tabpanel" aria-label="likes">

            </div>
        </div>
    </div>
</div>
