<div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-12">
    <div x-data="{ selectedTab: 'employeeList' }" class="w-full">
        <div class="flex justify-between pb-3">
            <h1 class="text-3xl font-bold  mr-auto">Employee Management</h1>
            @livewire('employee-management.employee-create')
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
                </div>
            </div>
        @endif
        <div x-data="{
            search: '',
            viewmodalIsOpen: false,
            EditmodalIsOpen: false,
            selectedEmployeeId: null,
            selectedEmployeeName: '',
            selectedEmployeeStatus: '',
            selectedEmployeeEmail: '',
            selectedEmployeeContact: '',
            selectedEmployeeDepartment: '',
            selectedEmployeePosition: '',
            selectedEmployeeHireDate: '',
            currentPage: 1,
            perPage: 10,
            rowsPerPageOptions: [10, 20, 50, 100],
            showContextMenu: false,
            contextMenuPosition: { x: 0, y: 0 },
            rightClickedEmployee: null,
            get totalPages() {
                return Math.ceil(this.filteredEmployees.length / this.perPage);
            },
            get filteredEmployees() {
                const query = this.search.toLowerCase();
                return [...$refs.employees.children].filter(row => {
                    const cells = row.querySelectorAll('td');
                    const id = cells[0]?.textContent.trim().toLowerCase();
                    const name = cells[1]?.textContent.trim().toLowerCase();
                    return id.includes(query) || name.includes(query);
                });
            },
            paginatedEmployees() {
                const start = (this.currentPage - 1) * this.perPage;
                const end = start + this.perPage;
                return this.filteredEmployees.slice(start, end);
            },
            openContextMenu(event, employee) {
                event.preventDefault();
                this.rightClickedEmployee = employee;
                this.contextMenuPosition = { x: event.clientX, y: event.clientY };
                this.showContextMenu = true;
            },
            closeContextMenu() {
                this.showContextMenu = false;
                this.rightClickedEmployee = null;
            },
            openViewModal(employee) {
                this.selectedEmployeeId = employee.id;
                this.selectedEmployeeName = `${employee.first_name} ${employee.last_name}`;
                this.selectedEmployeeStatus = employee.status;
                this.selectedEmployeeEmail = employee.email;
                this.selectedEmployeeContact = employee.contact;
                this.selectedEmployeeDepartment = employee.department ? employee.department.name : 'N/A';
                this.selectedEmployeePosition = employee.position ? employee.position.name : 'N/A';
                const hireDate = new Date(employee.created_at);
                this.selectedEmployeeHireDate = hireDate.toISOString().split('T')[0];
                this.viewmodalIsOpen = true;
            },
            closeViewModal() {
                this.viewmodalIsOpen = false;
                this.selectedEmployeeId = null;
                this.selectedEmployeeName = '';
            },
        }" class="overflow-x-auto rounded-lg border md:overflow-x-visible">
            <!-- Search Input -->
            <div class="flex justify-between items-center p-4">
                <div class="relative flex w-full max-w-xs flex-col gap-1 text-neutral-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input
                        type="search"
                        x-model="search"
                        class="w-full rounded-full bg-neutral-100 py-2 pl-10 pr-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75"
                        placeholder="Search by ID or Name"
                        aria-label="search"
                    />
                </div>
                <!-- Rows Per Page Dropdown -->
                <div class="flex items-center gap-2">
                    <label for="rowsPerPage" class="text-sm text-gray-600">Rows per page:</label>
                    <select id="rowsPerPage"
                            x-model="perPage"
                            @change="currentPage = 1"
                            class="border border-gray-300 rounded-md p-1 text-sm">
                        <template x-for="option in rowsPerPageOptions" :key="option">
                            <option :value="option" x-text="option"></option>
                        </template>
                    </select>
                </div>
            </div>

            <table class="min-w-full bg-white border table-auto md:w-full">
                <thead class="text-gray-500 border">
                    <tr>
                        <th class="p-4 text-sm text-center">ID</th>
                        <th class="text-sm text-left">NAME</th>
                        <th class="text-sm text-center">STATUS</th>
                        <th class="text-sm text-left">EMAIL</th>
                        <th class="text-sm text-left">CONTACT#</th>
                        <th class="text-sm text-left">DEPARTMENT</th>
                        <th class="text-sm text-left">POSITION</th>
                        <th class="text-sm text-left">HIRE DATE</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody x-ref="employees">
                    @if($employees->isEmpty())
                        <tr>
                            <td colspan="8" class="p-4 text-center justify-center">
                                <strong>No employees found</strong>
                            </td>
                        </tr>
                    @else
                    @foreach($employees as $employee)
                    <tr
                        x-show="paginatedEmployees().includes($el)"
                        x-transition
                        @contextmenu.prevent="openContextMenu($event, {{ json_encode($employee) }})"
                        @click="closeContextMenu()"
                        class="hover:bg-neutral-100  transition duration-300 ease-in-out"
                    >
                        <td class="p-1 text-center">{{ $employee->id }}</td>
                        <td class="">
                            <strong>{{ $employee->last_name }}, {{ $employee->first_name }}</strong>
                        </td>
                        <td class="text-center">
                            {{-- Badge based on status --}}
                            @if($employee->status === 'active')
                                <span class="w-fit inline-flex overflow-hidden rounded-full border border-green-500 bg-white text-xs font-medium text-green-500">
                                    <span class="rounded-full px-4 bg-green-500/10">Active</span>
                                </span>
                            @elseif($employee->status === 'inactive')
                                <span class="w-fit inline-flex overflow-hidden rounded-full border border-red-500 bg-white text-xs font-medium text-red-500">
                                    <span class="rounded-full px-4 bg-red-500/10">Inactive</span>
                                </span>
                            @elseif($employee->status === 'on leave')
                                <span class="w-fit inline-flex overflow-hidden rounded-full border border-amber-500 bg-white text-xs font-medium text-amber-500">
                                    <span class="rounded-full px-4 bg-amber-500/10">On Leave</span>
                                </span>
                            @elseif($employee->status === 'terminated')
                                <span class="w-fit inline-flex overflow-hidden rounded-full border border-neutral-800 bg-white text-xs font-medium text-neutral-800">
                                    <span class="rounded-full px-4 bg-neutral-800/10">Terminated</span>
                                </span>
                            @endif
                        </td>
                        <td class="">{{ $employee->email }}</td>
                        <td class="">{{ $employee->contact }}</td>
                        <td class="text-left ">{{ $employee->department->name }}</td>
                        <td class="text-left ">{{ $employee->position->name }}</td>
                        <td class="">{{ $employee->created_at->format('Y-m-d') }}</td>
                        <td class="p-1">
                            <div x-data="{ isOpen: false, openedWithKeyboard: false }" class="relative" @keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                                <!-- Toggle Button -->
                                <button type="button" @click="isOpen = !isOpen" class="inline-flex cursor-pointer items-center gap-2 whitespace-nowrap rounded-full p-2 text-sm font-medium tracking-wide transition hover:bg-blue-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-800" aria-haspopup="true" @keydown.space.prevent="openedWithKeyboard = true" @keydown.enter.prevent="openedWithKeyboard = true" @keydown.down.prevent="openedWithKeyboard = true" :class="isOpen || openedWithKeyboard ? 'text-neutral-900z'" :aria-expanded="isOpen || openedWithKeyboard">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M10.5 6a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm0 6a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm0 6a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard" @click.outside="isOpen = false, openedWithKeyboard = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" class="absolute left-0 mt-2 w-48 bg-white border border-neutral-200 shadow-lg rounded-md z-10" role="menu">
                                    <a @click="openViewModal({{ json_encode($employee) }})" class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-800/5 hover:text-neutral-900 focus-visible:bg-neutral-800/10 focus-visible:text-neutral-900 focus-visible:outline-none cursor-pointer">
                                        View
                                    </a>
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-800/5 hover:text-neutral-900 focus-visible:bg-neutral-800/10 focus-visible:text-neutral-900 focus-visible:outline-none">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('employee.delete', $employee->id) }}" class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-800/5 hover:text-neutral-900 focus-visible:bg-neutral-800/10 focus-visible:text-neutral-900 focus-visible:outline-none">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <!-- Context Menu -->
            <div x-show="showContextMenu"
                x-transition
                @click.outside="closeContextMenu()"
                @click="closeContextMenu()"
                :style="{ top: contextMenuPosition.y + 'px', left: contextMenuPosition.x + 'px' }"
                class="fixed bg-white border border-gray-300 rounded shadow-lg z-50">
                <ul class="py-1">
                    <!-- Context Menu "View" item -->
                    <li @click="openViewModal(rightClickedEmployee)"
                        class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-800/5 hover:text-neutral-900 focus-visible:bg-neutral-800/10 focus-visible:text-neutral-900 focus-visible:outline-none cursor-pointer">
                        View
                    </li>
                </ul>
            </div>
            <!-- Pagination Controls -->
            <nav aria-label="pagination" class="my-4">
                <ul class="flex flex-shrink-0 justify-center items-center gap-2 text-sm font-medium">
                    <li>
                        <a href="#"
                            @click.prevent="currentPage > 1 ? currentPage-- : null"
                            class="flex items-center rounded-md p-2 bg-white border"
                            aria-label="previous page"
                            :class="{
                                'text-gray-400 pointer-events-none': currentPage === 1,
                                'text-blue-500 bg-white hover:bg-blue-300': currentPage !== 1
                            }">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                            Previous
                        </a>
                    </li>
                    <template x-for="page in totalPages" :key="page">
                        <li>
                            <a href="#"
                            @click.prevent="currentPage = page"
                            class="flex size-6 items-center justify-center rounded-full p-5 border"
                            :class="page === currentPage ? 'text-gray-400 pointer-events-none' : 'text-blue-500 bg-white hover:bg-blue-300'"
                            :aria-current="page === currentPage ? 'page' : false"
                            :aria-label="'page ' + page">
                                <span x-text="page"></span>
                            </a>
                        </li>
                    </template>
                    <li>
                        <a href="#"
                            @click.prevent="currentPage < totalPages ? currentPage++ : null"
                            class="flex items-center rounded-md p-2 bg-white border"
                            aria-label="next page"
                            :class="{
                                'text-gray-400 pointer-events-none': currentPage === totalPages,
                                'text-blue-500 bg-white hover:bg-blue-300': currentPage !== totalPages
                            }">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
            @livewire('employee-management.view-employee')
        </div>
    </div>
</div>
