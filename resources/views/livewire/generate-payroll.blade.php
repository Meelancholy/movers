<div class="mb-8 bg-white rounded-lg p-6 shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Generate Payroll</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-md mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to handle payroll generation -->
    <div class="overflow-x-auto rounded-lg shadow-lg mb-8 md:overflow-x-visible">
        <table class="min-w-full bg-white border-collapse table-auto md:w-full">
            <thead class="bg-blue-100 text-gray-800">
                <tr>
                    <th class="p-4 text-left">Employee ID</th>
                    <th class="p-4 text-left">Employee Name</th>
                    <th class="p-4 text-left">Base Salary</th>
                    <th class="p-4 text-left">Gross Salary</th>
                    <th class="p-4 text-left">Withholdings</th>
                    <th class="p-4 text-left">Net Salary</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employeePayrollData as $employee)
                    <tr class="hover:bg-blue-50 transition duration-300 ease-in-out">
                        <td class="p-4 text-gray-800">{{ $employee['id'] }}</td>
                        <td class="p-4 text-gray-800 font-bold">{{ $employee['name'] }}</td>
                        <td class="p-4 text-blue-500 font-bold">₱{{ number_format($employee['baseSalary'], 2) }}</td>
                        <td class="p-4 text-green-500 font-bold">₱{{ number_format($employee['grossSalary'], 2) }}</td>
                        <td class="p-4 text-red-500 font-bold">₱{{ number_format($employee['withholdings'], 2) }}</td>
                        <td class="p-4 text-yellow-500 font-bold">₱{{ number_format($employee['netSalary'], 2) }}</td>
                        <td class="p-4 text-center">
                            <button type="button" wire:click="generatePayroll({{ $employee['id'] }})" class="bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">
                                Generate
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $employees->links() }} <!-- Add this line for pagination -->
    </div>
</div>
