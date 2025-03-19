<div>
    <div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-6">
        <h1 class="text-3xl font-bold text-gray-800 mr-auto">Employee Management</h1>
    </div>
    <div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-4 mt-2">
        <div class="container mx-auto border rounded-lg p-6">
            <!-- Search Bar -->
            <div class="flex justify-between">
                <div class="mb-4">
                    <input type="text" id="searchInput" placeholder="Search by ID or Name" class="w-full pl-2 pr-9 py-2 border rounded-lg">
                </div>

                <!-- Rows Per Page Selector -->
                <div class="mb-4 flex items-center space-x-4">
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
                    <tr class="bg-gray-300">
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(0)">ID ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(1)">Name ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(2)">Status ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(3)">Email ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(4)">Contact ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(5)">Department ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(6)">Position ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400" onclick="sortTable(7)">Created At ▲▼</th>
                        <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400"></th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                    @foreach($employees as $employee)
                        <tr class="border-b">
                            <td class="p-3">{{ $employee->id }}</td>
                            <td class="p-3">
                                <strong>{{ $employee->last_name }}, {{ $employee->first_name }}</strong>
                            </td>
                            <td class="p-3">
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
                            <td class="p-3">{{ $employee->email }}</td>
                            <td class="p-3">{{ $employee->contact }}</td>
                            <td class="p-3">{{ $employee->department }}</td>
                            <td class="p-3">{{ $employee->position }}</td>
                            <td class="p-3">{{ $employee->created_at->format('Y-m-d') }}</td>
                            <td class="p-3">                                    <!-- Dropdown Menu -->
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center">
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

        // Initialize table
        updateTable();

        // JavaScript for Search
        document.getElementById('searchInput').addEventListener('input', function () {
            filterTable();
        });

        // JavaScript for Rows Per Page
        document.getElementById('rowsPerPage').addEventListener('change', function () {
            rowsPerPage = parseInt(this.value);
            currentPage = 1; // Reset to first page
            updateTable();
        });

        // JavaScript for Pagination
        document.getElementById('prevPage').addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        document.getElementById('nextPage').addEventListener('click', function () {
            const totalPages = Math.ceil(allRows.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        // JavaScript for Sorting
        function sortTable(columnIndex) {
            const isNumericColumn = !isNaN(parseFloat(allRows[0].querySelector(`td:nth-child(${columnIndex + 1})`).textContent));

            if (currentColumn === columnIndex) {
                ascending = !ascending; // Toggle sort order
            } else {
                currentColumn = columnIndex;
                ascending = true; // Default to ascending for new column
            }

            allRows.sort((a, b) => {
                const aValue = a.querySelector(`td:nth-child(${columnIndex + 1})`).textContent;
                const bValue = b.querySelector(`td:nth-child(${columnIndex + 1})`).textContent;

                if (isNumericColumn) {
                    return ascending ? parseFloat(aValue) - parseFloat(bValue) : parseFloat(bValue) - parseFloat(aValue);
                } else {
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
            visibleRows.forEach(row => tableBody.appendChild(row));

            updatePaginationInfo();
        }

        // Update pagination information
        function updatePaginationInfo() {
            const totalRows = allRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            document.getElementById('paginationInfo').textContent = `Page ${currentPage} of ${totalPages} (${totalRows} rows)`;
        }

        // Update header arrows
        function updateHeaderArrows(columnIndex, ascending) {
            const headers = document.querySelectorAll('th');
            headers.forEach((header, index) => {
                header.innerHTML = header.innerHTML.replace('▲', '').replace('▼', ''); // Remove existing arrows
                if (index === columnIndex) {
                    header.innerHTML += ascending ? ' ▲' : ' ▼'; // Add arrow for current column
                }
            });
        }

        // Filter table based on search query
        function filterTable() {
            const searchQuery = document.getElementById('searchInput').value.toLowerCase();
            allRows = Array.from(document.querySelectorAll('#employeeTableBody tr'));

            allRows = allRows.filter(row => {
                const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                return id.includes(searchQuery) || name.includes(searchQuery);
            });

            currentPage = 1; // Reset to first page after filtering
            updateTable();
        }
    </script>
</div>
