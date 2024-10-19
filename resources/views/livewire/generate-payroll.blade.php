<div>
    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-md mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex justify-between mb-4">
        <div>
            <input type="text" wire:model="search" placeholder="Search Employees..." class="form-input" />
            <button wire:click="searchEmployees" class="btn btn-primary">Search</button>
        </div>

    </div>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">ID</th>
                <th class="py-2">Name</th>
                <th class="py-2">Base Salary</th>
                <th class="py-2">Gross Salary</th>
                <th class="py-2">Withholdings</th>
                <th class="py-2">Net Salary</th>
                <th class="py-2">Action</th> <!-- New Action Column -->
            </tr>
        </thead>
        <tbody>
            @foreach ($employeePayrollData as $payrollData)
                <tr>
                    <td class="border px-4 py-2">{{ $payrollData['id'] }}</td>
                    <td class="border px-4 py-2">{{ $payrollData['name'] }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['baseSalary'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['grossSalary'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['withholdings'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['netSalary'], 2) }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('payroll.show', $payrollData['id']) }}" class="btn btn-primary">View Payroll</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $employees->links() }}
</div>
