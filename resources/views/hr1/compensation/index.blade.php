@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-8 bg-gray-100 p-6 rounded-lg shadow-md">
    <h1 class="text-4xl font-bold text-blue-800 mb-8">Compensation Management</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-md mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-6 space-x-4">
        <a href="{{ route('compensation.create_deduction') }}" class="bg-orange-600 text-white font-semibold px-5 py-3 rounded-lg shadow hover:bg-orange-700 transition duration-200 ease-in-out">
            Add Deduction
        </a>
        <a href="{{ route('compensation.create_bonus') }}" class="bg-blue-600 text-white font-semibold px-5 py-3 rounded-lg shadow hover:bg-blue-700 transition duration-200 ease-in-out">
            Add Bonus
        </a>
    </div>

    <!-- Searchable Dropdown -->
    <div class="mb-6 relative">
        <input type="text" id="employeeSearch" placeholder="Search by name or ID..." class="p-2 border border-gray-300 rounded-lg w-full mb-2" onkeyup="filterEmployees()">
    </div>

    <div class="overflow-hidden rounded-lg shadow-lg bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Employee ID</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Employee</th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Social Benefits</th>
                    <th onclick="toggleSort('deductions')" class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider cursor-pointer">
                        Total Deductions
                        <span id="deductionsSortIcon" class="ml-1"></span>
                    </th>
                    <th onclick="toggleSort('bonuses')" class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider cursor-pointer">
                        Total Compensation Enhancements
                        <span id="bonusesSortIcon" class="ml-1"></span>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="employeeTable" class="bg-white divide-y divide-gray-200">
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out employee-row">
                        <td class="px-6 py-4 text-base font-medium text-gray-900">{{ $employee->id }}</td>
                        <td class="px-6 py-4 text-base font-medium text-gray-900">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </td>
                        <td class="px-6 py-4 text-base">
                            @if($employee->contributions->isNotEmpty())
                                @php
                                    $contribution = $employee->contributions->first();
                                    $philhealthActive = $contribution->philhealth;
                                    $sssActive = $contribution->sss;
                                    $pagibigActive = $contribution->pagibig;
                                @endphp
                                <div class="flex space-x-2">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full border-2 {{ $philhealthActive ? 'bg-green-500' : 'bg-gray-300' }} transition-colors duration-200"></div>
                                        <span class="ml-1">PhilHealth</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full border-2 {{ $sssActive ? 'bg-green-500' : 'bg-gray-300' }} transition-colors duration-200"></div>
                                        <span class="ml-1">SSS</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full border-2 {{ $pagibigActive ? 'bg-green-500' : 'bg-gray-300' }} transition-colors duration-200"></div>
                                        <span class="ml-1">Pag-IBIG</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-gray-500">No Contributions</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-base text-orange-600 font-semibold">
                            @if($employee->deductions->isNotEmpty())
                                @php $totalDeductions = $employee->deductions->sum('amount'); @endphp
                                ₱{{ number_format($totalDeductions, 2) }}
                            @else
                                ₱0.00
                            @endif
                        </td>
                        <td class="px-6 py-4 text-base text-blue-600 font-semibold">
                            @if($employee->bonuses->isNotEmpty())
                                @php $totalBonuses = $employee->bonuses->sum('amount'); @endphp
                                ₱{{ number_format($totalBonuses, 2) }}
                            @else
                                ₱0.00
                            @endif
                        </td>
                        <td class="px-6 py-4 text-base flex space-x-2">
                            <a href="{{ route('compensation.edit', $employee->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-150">Edit</a>
                            <a href="{{ route('compensation.view', $employee->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-150">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    let deductionsSortOrder = 'asc'; // Default sort order
    let bonusesSortOrder = 'asc'; // Default sort order

    function filterEmployees() {
        const searchInput = document.getElementById('employeeSearch');
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('#employeeTable .employee-row');

        rows.forEach(row => {
            const employeeId = row.children[0].textContent.toLowerCase();
            const employeeName = row.children[1].textContent.toLowerCase();

            if (employeeId.includes(filter) || employeeName.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function toggleSort(column) {
        if (column === 'deductions') {
            deductionsSortOrder = deductionsSortOrder === 'asc' ? 'desc' : 'asc';
            sortTable('deductions', deductionsSortOrder);
        } else if (column === 'bonuses') {
            bonusesSortOrder = bonusesSortOrder === 'asc' ? 'desc' : 'asc';
            sortTable('bonuses', bonusesSortOrder);
        }
    }

    function sortTable(column, order) {
        const table = document.getElementById('employeeTable');
        const rows = Array.from(table.querySelectorAll('.employee-row'));

        rows.sort((a, b) => {
            let aValue, bValue;

            if (column === 'deductions') {
                aValue = parseFloat(a.children[3].textContent.replace(/[₱,]/g, '').trim());
                bValue = parseFloat(b.children[3].textContent.replace(/[₱,]/g, '').trim());
            } else if (column === 'bonuses') {
                aValue = parseFloat(a.children[4].textContent.replace(/[₱,]/g, '').trim());
                bValue = parseFloat(b.children[4].textContent.replace(/[₱,]/g, '').trim());
            } else {
                aValue = parseInt(a.children[0].textContent);
                bValue = parseInt(b.children[0].textContent);
            }

            return order === 'asc' ? aValue - bValue : bValue - aValue;
        });

        // Append sorted rows to the table
        rows.forEach(row => table.appendChild(row));

        // Update sort icon
        updateSortIcons(column, order);
    }

    function updateSortIcons(column, order) {
        const deductionsIcon = document.getElementById('deductionsSortIcon');
        const bonusesIcon = document.getElementById('bonusesSortIcon');

        if (column === 'deductions') {
            deductionsIcon.innerHTML = order === 'asc' ? '↑' : '↓';
            bonusesIcon.innerHTML = ''; // Clear bonuses icon
        } else if (column === 'bonuses') {
            bonusesIcon.innerHTML = order === 'asc' ? '↑' : '↓';
            deductionsIcon.innerHTML = ''; // Clear deductions icon
        }
    }
</script>

@endsection
