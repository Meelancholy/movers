<div class="container min-w-full bg-white p-6 rounded-lg shadow-md md:p-12">
    <!-- Title Section -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Payroll Records</h1>
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
