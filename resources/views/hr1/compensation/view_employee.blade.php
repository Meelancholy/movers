@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold text-blue-600 mb-6">Employee Compensation Details</h2>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold text-gray-800">{{ $employee->last_name }}, {{ $employee->first_name }}</h3>
        <p class="text-gray-600"><strong>Employee ID:</strong> {{ $employee->id }}</p>
        <p class="text-gray-600"><strong>Email:</strong> {{ $employee->email }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Base Salary -->
        <div class="bg-green-100 shadow-lg rounded-lg p-6">
            <h4 class="font-bold text-lg text-green-700">Base Salary</h4>
            <p class="text-green-800 text-xl">₱{{ number_format($salary, 2) }}</p>
        </div>



    <!-- Contributions Section -->
    <div class="bg-purple-100 shadow-lg rounded-lg p-6">
        <h4 class="font-bold text-lg text-purple-700">Social</h4>
        <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-hidden mt-4">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">Type</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Employee Share</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Employer Share</th>
                </tr>
            </thead>
            <tbody class="bg-purple-50">
                <!-- SSS -->
                @if (isset($sssContribution) && ($sssContribution['employee_share'] > 0 || $sssContribution['employer_share'] > 0))
                <tr class="hover:bg-purple-200">
                    <td class="border px-4 py-2 text-gray-800">SSS</td>
                    <td class="border px-4 py-2 text-purple-800">₱{{ number_format($sssContribution['employee_share'], 2) }}</td>
                    <td class="border px-4 py-2 text-purple-800">₱{{ number_format($sssContribution['employer_share'], 2) }}</td>
                </tr>
                @endif

                <!-- PhilHealth -->
                @if (isset($philhealth_employee_share) && ($philhealth_employee_share > 0 || $philhealth_employer_share > 0))
                <tr class="hover:bg-purple-200">
                    <td class="border px-4 py-2 text-gray-800">PhilHealth</td>
                    <td class="border px-4 py-2 text-purple-800">₱{{ number_format($philhealth_employee_share, 2) }}</td>
                    <td class="border px-4 py-2 text-purple-800">₱{{ number_format($philhealth_employer_share, 2) }}</td>
                </tr>
                @endif

                <!-- Pag-IBIG -->
                @if (isset($pagibig_employee_share) && ($pagibig_employee_share > 0 || $pagibig_employer_share > 0))
                <tr class="hover:bg-purple-200">
                    <td class="border px-4 py-2 text-gray-800">Pag-IBIG</td>
                    <td class="border px-4 py-2 text-purple-800">₱{{ number_format($pagibig_employee_share, 2) }}</td>
                    <td class="border px-4 py-2 text-purple-800">₱{{ number_format($pagibig_employer_share, 2) }}</td>
                </tr>
                @endif
            </tbody>
            <tfoot class="bg-purple-200">
                <tr>
                    <td class="border px-4 py-2 font-bold text-purple-700">Total</td>
                    <td class="border px-4 py-2 font-bold text-purple-900">₱{{ number_format(
                        ($sssContribution['employee_share'] ?? 0) +
                        ($philhealth_employee_share ?? 0) +
                        ($pagibig_employee_share ?? 0), 2) }}</td>
                    <td class="border px-4 py-2 font-bold text-purple-900">₱{{ number_format(
                        ($sssContribution['employer_share'] ?? 0) +
                        ($philhealth_employer_share ?? 0) +
                        ($pagibig_employer_share ?? 0), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>




        <!-- Deductions -->
        <div class="bg-orange-100 shadow-lg rounded-lg p-6">
            <h4 class="font-bold text-lg text-orange-700">Deductions</h4>
            @if($employee->deductions->isEmpty())
                <p class="text-gray-600">No deductions available.</p>
            @else
                <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-hidden mt-4">
                    <thead class="bg-orange-600 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium">Deduction Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-orange-50">
                        @foreach($employee->deductions as $deduction)
                            <tr class="hover:bg-orange-200">
                                <td class="border px-4 py-2 text-gray-800">{{ $deduction->deduction_name }}</td>
                                <td class="border px-4 py-2 text-orange-800">₱{{ number_format($deduction->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-orange-200">
                        <tr>
                            <td class="border px-4 py-2 font-bold text-orange-700">Total Deductions</td>
                            <td class="border px-4 py-2 font-bold text-orange-900">₱{{ number_format($employee->deductions->sum('amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>

        <!-- Bonuses -->
        <div class="bg-blue-300 shadow-lg rounded-lg p-6">
            <h4 class="font-bold text-lg text-blue-700">Bonuses</h4>
            @if($employee->bonuses->isEmpty())
                <p class="text-gray-600">No bonuses available.</p>
            @else
                <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-hidden mt-4">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium">Bonus Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-blue-50">
                        @foreach($employee->bonuses as $bonus)
                            <tr class="hover:bg-blue-200">
                                <td class="border px-4 py-2 text-gray-800">{{ $bonus->bonus_name }}</td>
                                <td class="border px-4 py-2 text-blue-800">₱{{ number_format($bonus->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-blue-200">
                        <tr>
                            <td class="border px-4 py-2 font-bold text-blue-700">Total Bonuses</td>
                            <td class="border px-4 py-2 font-bold text-blue-900">₱{{ number_format($employee->bonuses->sum('amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('compensation.edit', $employee->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">Edit Employee</a>
        <a href="{{ route('compensation.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">Back to Dashboard</a>
    </div>
</div>
@endsection
