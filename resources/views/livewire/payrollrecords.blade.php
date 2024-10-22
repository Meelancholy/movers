<div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-12">
    <!-- Title Section -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Payroll Records</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-md mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter and Search Form -->
    <form method="GET" class="mb-8" wire:submit.prevent="searchEmployees">
        <div class="flex items-center justify-between w-full">
            <!-- Left-aligned Filters -->
            <div class="flex">
                <div class="flex items-center border border-gray-300 rounded-l-full py-2 pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" wire:model="search" placeholder="Search Employees..." class="form-input focus:outline-none w-64" />
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-10 py-2 rounded-r-full transition shadow-lg">
                    Search
                </button>
            </div>
        </div>
    </form>

    <!-- Payroll Table -->
    <div class="overflow-x-auto rounded-lg shadow-lg mb-8 md:overflow-x-visible">
        <table class="min-w-full bg-white border-collapse table-auto md:w-full">
            <thead class="bg-blue-100 text-gray-800">
                <tr>
                    <th class="p-4 text-left">Employee ID</th>
                    <th class="p-4 text-left">Employee Name</th>
                    <th class="p-4 text-center">Salary</th>
                    <th class="p-4 text-center">Gross Salary</th>
                    <th class="p-4 text-center">Withholdings</th>
                    <th class="p-4 text-center">Net Salary</th>
                    <th class="p-4 text-left">Date and Time</th>
                    <th class="p-4 text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                <tr class="hover:bg-blue-50 transition duration-300 ease-in-out">
                    <td class="p-4 text-gray-800">{{ $payroll->employee->id }}</td>
                    <td class="p-4 text-gray-800"><strong>{{ $payroll->employee->first_name . ' ' . $payroll->employee->last_name }}</strong></td>
                    <td class="p-4 text-center text-blue-500"><strong>₱{{ number_format($payroll->salary, 2) }}</strong></td>
                    <td class="p-4 text-center text-green-500"><strong>₱{{ number_format($payroll->gross_salary, 2) }}</strong></td>
                    <td class="p-4 text-center text-red-500"><strong>₱{{ number_format($payroll->withholdings, 2) }}</strong></td>
                    <td class="p-4 text-center text-yellow-500"><strong>₱{{ number_format($payroll->net_salary, 2) }}</strong></td>
                    <td class="p-4">{{ $payroll->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="p-4 text-center">
                        <a href="{{ route('payroll.viewRecord', $payroll->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-full hover:bg-blue-600">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500">No payroll records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6 flex justify-center">
        {{ $payrolls->links() }}
    </div>
</div>
