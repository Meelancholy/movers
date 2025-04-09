<div>
    <div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-6">
        <h1 class="text-3xl font-bold text-gray-800 mr-auto">Employee Management</h1>
    </div>
    <div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-4 mt-2">
        <div class="container mx-auto border rounded-lg py-6">
            <!-- Search and Filter Bar -->
            <div class="flex flex-col md:flex-row justify-between gap-4 px-4 py-2">
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <input type="text" id="searchInput" placeholder="Search by ID or Name"
                        class="bg-gray-100 w-full md:w-64 pl-2 pr-9 py-1 border rounded-full">

                    <!-- Department Filter -->
                    <select id="departmentFilter" class="bg-gray-100 p-1 border rounded-full">
                        <option value="">All Departments</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->department }}">{{ $employee->department }}</option>
                        @endforeach
                    </select>

                    <!-- Position Filter -->
                    <select id="positionFilter" class="bg-gray-100 p-1 border rounded-full">
                        <option value="">All Positions</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->position }}">{{ $employee->position }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Rows Per Page Selector -->
                <div class="flex items-center space-x-4 p-2">
                    <label for="rowsPerPage" class="text-sm">Rows per page:</label>
                    <select id="rowsPerPage" class="p-2 border rounded-lg">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <!-- Employee Table -->
            <table class="w-full bg-white">
                <thead class="">
                    <tr class="bg-white border">
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(0)">
                            ID ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(1)">
                            Name ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(2)">
                            Status ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(3)">
                            Email ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(4)">
                            Contact ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(5)">
                            Department ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(6)">
                            Position ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(7)">
                            Hire Date ▲▼</th>
                        <th class="text-left cursor-pointer text-gray-700 hover:bg-gray-400"></th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @foreach ($employees as $employee)
                        <tr class="border-b">
                            <td class="p-3">{{ $employee->id }}</td>
                            <td class="p-3">
                                <strong>{{ $employee->last_name }}, {{ $employee->first_name }}</strong>
                            </td>
                            <td class="p-3">
                                @if ($employee->status === 'active')
                                    <span
                                        class="w-fit inline-flex overflow-hidden rounded-full border border-green-500 bg-white text-xs font-medium text-green-500">
                                        <span class="rounded-full px-4 bg-green-500/10">Active</span>
                                    </span>
                                @elseif($employee->status === 'inactive')
                                    <span
                                        class="w-fit inline-flex overflow-hidden rounded-full border border-red-500 bg-white text-xs font-medium text-red-500">
                                        <span class="rounded-full px-4 bg-red-500/10">Inactive</span>
                                    </span>
                                @elseif($employee->status === 'on leave')
                                    <span
                                        class="w-fit inline-flex overflow-hidden rounded-full border border-amber-500 bg-white text-xs font-medium text-amber-500">
                                        <span class="rounded-full px-4 bg-amber-500/10">On Leave</span>
                                    </span>
                                @elseif($employee->status === 'terminated')
                                    <span
                                        class="w-fit inline-flex overflow-hidden rounded-full border border-neutral-800 bg-white text-xs font-medium text-neutral-800">
                                        <span class="rounded-full px-4 bg-neutral-800/10">Terminated</span>
                                    </span>
                                @endif
                            </td>
                            <td class="p-3">{{ $employee->email }}</td>
                            <td class="p-3">{{ $employee->contact }}</td>
                            <td class="p-3">{{ $employee->department }}</td>
                            <td class="p-3">{{ $employee->position }}</td>
                            <td class="p-3" data-timestamp="{{ $employee->created_at->getTimestamp() }}">
                                {{ $employee->created_at->format('Y-m-d') }}
                            </td>
                            <td class="">
                                <div x-data="{ isOpen: false, openedWithKeyboard: false }"
                                    x-on:keydown.esc.prevent="isOpen = false, openedWithKeyboard = false"
                                    class="relative w-fit">
                                    <button type="button" aria-label="context menu" x-on:click="isOpen = ! isOpen"
                                        x-on:contextmenu.prevent="isOpen = true"
                                        x-on:keydown.space.prevent="openedWithKeyboard = true"
                                        x-on:keydown.enter.prevent="openedWithKeyboard = true"
                                        x-on:keydown.down.prevent="openedWithKeyboard = true"
                                        class="inline-flex items-center bg-transparent transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-outline-strong active:opacity-100 dark:focus-visible:outline-outline-dark-strong"
                                        x-bind:class="isOpen || openedWithKeyboard ?
                                            'text-on-surface-strong dark:text-on-surface-dark-strong' :
                                            'text-on-surface dark:text-on-surface-dark'"
                                        x-bind:aria-expanded="isOpen || openedWithKeyboard" aria-haspopup="true">
                                        <span class="w-8 h-8">☰</span>
                                    </button>
                                    <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition
                                        x-trap="openedWithKeyboard"
                                        x-on:click.outside="isOpen = false, openedWithKeyboard = false"
                                        x-on:keydown.down.prevent="$focus.wrap().next()"
                                        x-on:keydown.up.prevent="$focus.wrap().previous()"
                                        class="absolute top-8 right-0 flex w-fit min-w-48 flex-col divide-y divide-outline overflow-hidden rounded-radius border-outline bg-white dark:divide-outline-dark dark:border-outline-dark"
                                        role="menu">
                                        <a href="{{ route('employee.edit', $employee->id) }}"
                                            class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-800/5 hover:text-neutral-900 focus-visible:bg-neutral-800/10 focus-visible:text-neutral-900 focus-visible:outline-none">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('employee.delete', $employee->id) }}"
                                            class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-800/5 hover:text-neutral-900 focus-visible:bg-neutral-800/10 focus-visible:text-neutral-900 focus-visible:outline-none">
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
                </tbody>
            </table>
            @livewire('virtual-assistant')
            <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center p-2">
                <div id="paginationInfo" class="text-sm"></div>
                <div class="flex space-x-2">
                    <button id="prevPage" class="p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">Previous</button>
                    <button id="nextPage" class="p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">Next</button>
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

            allRows = originalRows.filter(row => {
                const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const department = row.querySelector('td:nth-child(6)').textContent;
                const position = row.querySelector('td:nth-child(7)').textContent;

                // Check search query
                const matchesSearch = id.includes(searchQuery) || name.includes(searchQuery);

                // Check department filter
                const matchesDepartment = departmentFilter === '' || department === departmentFilter;

                // Check position filter
                const matchesPosition = positionFilter === '' || position === positionFilter;

                return matchesSearch && matchesDepartment && matchesPosition;
            });

            currentPage = 1;
            updateTable();
        }
    </script>
</div>
