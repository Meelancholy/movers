@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container min-w-full">
    <h2 class="text-3xl font-bold mb-6 text-2D3748">Payroll Details for {{ $employee->first_name }} {{ $employee->last_name }}</h2>

    <div class="mb-8">
        <h3 class="text-2xl font-semibold mb-4">Payroll Overview</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-blue-100 text-2D3748">
                <tr>
                    <th class="py-2 border-b">Base Salary</th>
                    <th class="py-2 border-b">Gross Salary</th>
                    <th class="py-2 border-b">Withholdings</th>
                    <th class="py-2 border-b">Net Salary</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ number_format($payrollData['baseSalary'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['grossSalary'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['withholdings'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['netSalary'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex mb-8 space-x-8">
        <div class="flex-1">
            <h3 class="text-2xl font-semibold mb-4">Bonuses</h3>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-blue-100 text-2D3748">
                    <tr>
                        <th class="py-2 border-b">Name</th>
                        <th class="py-2 border-b">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee->bonuses as $bonus) <!-- Assuming relationship is defined -->
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $bonus->bonus_name }}</td>
                            <td class="border px-4 py-2">{{ number_format($bonus->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-bold bg-gray-100">
                        <td class="border px-4 py-2">Total Bonuses</td>
                        <td class="border px-4 py-2">{{ number_format($payrollData['bonuses'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex-1">
            <h3 class="text-2xl font-semibold mb-4">Deductions</h3>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-blue-100 text-2D3748">
                    <tr>
                        <th class="py-2 border-b">Name</th>
                        <th class="py-2 border-b">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee->deductions as $deduction) <!-- Assuming relationship is defined -->
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $deduction->deduction_name }}</td>
                            <td class="border px-4 py-2">{{ number_format($deduction->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-bold bg-gray-100">
                        <td class="border px-4 py-2">Total Deductions</td>
                        <td class="border px-4 py-2">{{ number_format($payrollData['deductions'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-2xl font-semibold mb-4">Contributions and Taxes</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-blue-100 text-2D3748">
                <tr>
                    <th class="py-2 border-b">Type</th>
                    <th class="py-2 border-b">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">PhilHealth (Employee Share)</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['philhealth']['employee_share'], 2) }}</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">PhilHealth (Employer Share)</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['philhealth']['employer_share'], 2) }}</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">SSS Contribution (Employee Share)</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['sssContribution']['employee_share'], 2) }}</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">SSS Contribution (Employer Share)</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['sssContribution']['employer_share'], 2) }}</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">Pag-IBIG (Employee Share)</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['pagibig']['employee_share'], 2) }}</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">Pag-IBIG (Employer Share)</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['pagibig']['employer_share'], 2) }}</td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">Tax</td>
                    <td class="border px-4 py-2">{{ number_format($payrollData['tax'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between mt-4">
        <a href="{{ route('payroll.records') }}" class="bg-gray-300 text-2D3748 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Back to Payroll Records</a>

        <form action="{{ route('payroll.finalize', $employee->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">Finalize Payroll</button>
        </form>
    </div>
</div>
@endsection
