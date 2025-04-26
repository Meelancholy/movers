<div>
    <div class="container min-w-full bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Employee Management</h1>
            <a href="{{ route('employee.archive')}}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                View Archived Employees
            </a>
        </div>
    </div>

    <div class="container min-w-full bg-white p-6 rounded-lg shadow-md mt-4">
        <div class="border rounded-lg overflow-hidden">
            <!-- Search and Filter Bar -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-4 bg-white">
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search by ID or Name"
                            class="bg-white w-full md:w-64 pl-3 pr-8 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                <!-- Department Filter -->
                <select id="departmentFilter" class="bg-white p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Departments</option>
                    @foreach($employees->pluck('department')->unique() as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>

                <!-- Position Filter -->
                <select id="positionFilter" class="bg-white p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Positions</option>
                    @foreach($employees->pluck('position')->unique() as $position)
                        <option value="{{ $position }}">{{ $position }}</option>
                    @endforeach
                </select>

                    <!-- Hire Date Range Filter -->
                    <div class="flex items-center gap-2 bg-white p-2 border rounded-lg">
                        <label for="hireDateFrom" class="text-sm whitespace-nowrap">Hire Date:</label>
                        <input type="date" id="hireDateFrom" class="p-1 border rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500">to</span>
                        <input type="date" id="hireDateTo" class="p-1 border rounded focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Rows Per Page Selector -->
                <div class="flex items-center space-x-2">
                    <label for="rowsPerPage" class="text-sm">Rows per page:</label>
                    <select id="rowsPerPage" class="p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <!-- Employee Table -->
            <div class="overflow-x-auto">
                <table class="w-full bg-white">
                    <thead class="bg-white">
                        <tr>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(0)">
                                ID <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(1)">
                                Name <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(2)">
                                Status <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(3)">
                                Email <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(4)">
                                Contact <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(5)">
                                Department <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(6)">
                                Position <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-blue-100 transition-colors" onclick="sortTable(7)">
                                Hire Date <span class="sort-icon">▲▼</span></th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody">
                        @foreach ($employees as $employee)
                            <tr class="border-b hover:bg-blue-50 transition-colors">
                                <td class="p-3">{{ $employee->id }}</td>
                                <td class="p-3 font-medium">
                                    {{ $employee->last_name }}, {{ $employee->first_name }}
                                </td>
                                <td class="p-3">
                                    @if ($employee->status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @elseif($employee->status === 'inactive')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @elseif($employee->status === 'on leave')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            On Leave
                                        </span>
                                    @elseif($employee->status === 'terminated')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Terminated
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-blue-600 hover:underline"><a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a></td>
                                <td class="p-3">{{ $employee->contact }}</td>
                                <td class="p-3">{{ $employee->department }}</td>
                                <td class="p-3">{{ $employee->position }}</td>
                                <td class="p-3" data-timestamp="{{ $employee->created_at->getTimestamp() }}">
                                    {{ $employee->created_at->format('Y-m-d') }}
                                </td>
                                <td class="p-3 relative">
                                    <div x-data="{ isOpen: false, openedWithKeyboard: false }"
                                        x-on:keydown.esc.prevent="isOpen = false, openedWithKeyboard = false"
                                        class="relative inline-block">
                                        <button type="button" aria-label="Employee actions"
                                            x-on:click="isOpen = !isOpen"
                                            x-on:contextmenu.prevent="isOpen = true"
                                            x-on:keydown.space.prevent="openedWithKeyboard = true"
                                            x-on:keydown.enter.prevent="openedWithKeyboard = true"
                                            x-on:keydown.down.prevent="openedWithKeyboard = true"
                                            class="p-1 rounded hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            x-bind:aria-expanded="isOpen || openedWithKeyboard"
                                            aria-haspopup="true">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition
                                            x-trap="openedWithKeyboard"
                                            x-on:click.outside="isOpen = false, openedWithKeyboard = false"
                                            x-on:keydown.down.prevent="$focus.wrap().next()"
                                            x-on:keydown.up.prevent="$focus.wrap().previous()"
                                            class="absolute right-0 z-20 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                            x-bind:style="{
                                                'left': $el.getBoundingClientRect().right > window.innerWidth ? 'auto' : 'auto',
                                                'right': $el.getBoundingClientRect().right > window.innerWidth ? '0' : 'auto'
                                            }"
                                            role="menu">
                                            <a href="{{ route('employees.show', $employee->id) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                                role="menuitem">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    View
                                                </div>
                                            </a>
                                            <a href="{{ route('employee.edit', $employee->id) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                                role="menuitem">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </div>
                                            </a>
                                            <button wire:click="setInactive({{ $employee->id }})"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                                Inactive
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button id="prevPageMobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-blue-100">
                            Previous
                        </button>
                        <button id="nextPageMobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-blue-100">
                            Next
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p id="paginationInfo" class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <button id="prevPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-blue-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="pageNumbers" class="flex">
                                    <!-- Page numbers will be inserted here -->
                                </div>
                                <button id="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-blue-50">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
<script>
    let currentColumn = null;
    let ascending = true;
    let currentPage = 1;
    let rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
    let allRows = Array.from(document.querySelectorAll('#employeeTableBody tr'));
    let originalRows = Array.from(document.querySelectorAll('#employeeTableBody tr'));

    // Initialize table
    updateTable();

    // JavaScript for Search and Filters
    document.getElementById('searchInput').addEventListener('input', function() {
        filterTable();
    });

    document.getElementById('departmentFilter').addEventListener('change', function() {
        filterTable();
    });

    document.getElementById('positionFilter').addEventListener('change', function() {
        filterTable();
    });

    document.getElementById('hireDateFrom').addEventListener('change', function() {
        filterTable();
    });

    document.getElementById('hireDateTo').addEventListener('change', function() {
        filterTable();
    });

    // JavaScript for Rows Per Page
    document.getElementById('rowsPerPage').addEventListener('change', function() {
        rowsPerPage = parseInt(this.value);
        currentPage = 1;
        updateTable();
    });

    // JavaScript for Pagination
    document.getElementById('prevPage').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });

    document.getElementById('nextPage').addEventListener('click', function() {
        const totalPages = Math.ceil(allRows.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updateTable();
        }
    });

    // JavaScript for Sorting with Timestamp support
    function sortTable(columnIndex) {
        if (allRows.length === 0) return;

        const columnContent = allRows[0].querySelector(`td:nth-child(${columnIndex + 1})`).textContent;
        const isNumericColumn = !isNaN(parseFloat(columnContent));
        const isDateColumn = columnIndex === 7; // Hire Date is the 8th column (index 7)

        if (currentColumn === columnIndex) {
            ascending = !ascending;
        } else {
            currentColumn = columnIndex;
            ascending = true;
        }

        allRows.sort((a, b) => {
            const aCell = a.querySelector(`td:nth-child(${columnIndex + 1})`);
            const bCell = b.querySelector(`td:nth-child(${columnIndex + 1})`);

            // For timestamp columns, use the data-timestamp attribute
            if (isDateColumn) {
                const aTimestamp = parseInt(aCell.getAttribute('data-timestamp'));
                const bTimestamp = parseInt(bCell.getAttribute('data-timestamp'));
                return ascending ? aTimestamp - bTimestamp : bTimestamp - aTimestamp;
            }
            // For numeric columns
            else if (isNumericColumn) {
                const aValue = parseFloat(aCell.textContent);
                const bValue = parseFloat(bCell.textContent);
                return ascending ? aValue - bValue : bValue - aValue;
            }
            // For text columns
            else {
                const aValue = aCell.textContent.toLowerCase();
                const bValue = bCell.textContent.toLowerCase();
                return ascending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            }
        });

        updateTable();
        updateHeaderArrows(columnIndex, ascending);
    }

    // Update table based on current page and rows per page
    function updateTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = allRows.slice(start, end);

        const tableBody = document.getElementById('employeeTableBody');
        tableBody.innerHTML = '';
        visibleRows.forEach(row => tableBody.appendChild(row.cloneNode(true)));

        updatePaginationInfo();
        updatePaginationButtons();
    }

    // Update pagination information
    function updatePaginationInfo() {
        const totalRows = allRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const startRow = totalRows > 0 ? (currentPage - 1) * rowsPerPage + 1 : 0;
        const endRow = Math.min(currentPage * rowsPerPage, totalRows);

        document.getElementById('paginationInfo').textContent =
            `Showing ${startRow}-${endRow} of ${totalRows} employees`;
    }

    // Update pagination button states
    function updatePaginationButtons() {
        const totalPages = Math.ceil(allRows.length / rowsPerPage);
        document.getElementById('prevPage').disabled = currentPage <= 1;
        document.getElementById('nextPage').disabled = currentPage >= totalPages;
    }

    // Update header arrows
    function updateHeaderArrows(columnIndex, ascending) {
        const headers = document.querySelectorAll('th');
        headers.forEach((header, index) => {
            header.innerHTML = header.innerHTML.replace('▲', '').replace('▼', '');
            if (index === columnIndex) {
                header.innerHTML += ascending ? ' ▲' : ' ▼';
            }
        });
    }

    // Filter table based on search query and filters
    function filterTable() {
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();
        const departmentFilter = document.getElementById('departmentFilter').value;
        const positionFilter = document.getElementById('positionFilter').value;
        const hireDateFrom = document.getElementById('hireDateFrom').value;
        const hireDateTo = document.getElementById('hireDateTo').value;

        allRows = originalRows.filter(row => {
            const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const department = row.querySelector('td:nth-child(6)').textContent;
            const position = row.querySelector('td:nth-child(7)').textContent;
            const hireDateCell = row.querySelector('td:nth-child(8)');
            const hireDateTimestamp = parseInt(hireDateCell.getAttribute('data-timestamp'));
            const hireDate = new Date(hireDateTimestamp * 1000);
            const hireDateStr = hireDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD

            // Check search query
            const matchesSearch = id.includes(searchQuery) || name.includes(searchQuery);

            // Check department filter
            const matchesDepartment = departmentFilter === '' || department === departmentFilter;

            // Check position filter
            const matchesPosition = positionFilter === '' || position === positionFilter;

            // Check hire date range
            let matchesHireDate = true;
            if (hireDateFrom) {
                matchesHireDate = matchesHireDate && hireDateStr >= hireDateFrom;
            }
            if (hireDateTo) {
                matchesHireDate = matchesHireDate && hireDateStr <= hireDateTo;
            }

            return matchesSearch && matchesDepartment && matchesPosition && matchesHireDate;
        });

        currentPage = 1;
        updateTable();
    }
</script>
