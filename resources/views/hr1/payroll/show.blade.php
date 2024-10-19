@extends('hr1.layouts.app')

@section('content')
<div>

    <h2 class="text-2xl font-bold mb-4">Payroll Details for {{ $employee->first_name }} {{ $employee->last_name }}</h2>

    <table class="min-w-full bg-white mb-4">
        <thead>
            <tr>
                <th class="py-2">Base Salary</th>
                <th class="py-2">Gross Salary</th>
                <th class="py-2">Withholdings</th>
                <th class="py-2">Net Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">{{ number_format($payrollData['baseSalary'], 2) }}</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['grossSalary'], 2) }}</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['withholdings'], 2) }}</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['netSalary'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h3 class="text-xl font-semibold mb-2">Bonuses</h3>
    <table class="min-w-full bg-white mb-4">
        <thead>
            <tr>
                <th class="py-2">Description</th>
                <th class="py-2">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee->bonuses as $bonus) <!-- Assuming relationship is defined -->
                <tr>
                    <td class="border px-4 py-2">{{ $bonus->description }}</td>
                    <td class="border px-4 py-2">{{ number_format($bonus->amount, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="border px-4 py-2 font-bold">Total Bonuses</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['bonuses'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h3 class="text-xl font-semibold mb-2">Deductions</h3>
    <table class="min-w-full bg-white mb-4">
        <thead>
            <tr>
                <th class="py-2">Description</th>
                <th class="py-2">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee->deductions as $deduction) <!-- Assuming relationship is defined -->
                <tr>
                    <td class="border px-4 py-2">{{ $deduction->description }}</td>
                    <td class="border px-4 py-2">{{ number_format($deduction->amount, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="border px-4 py-2 font-bold">Total Deductions</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['deductions'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h3 class="text-xl font-semibold mb-2">Contributions and Taxes</h3>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Type</th>
                <th class="py-2">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">PhilHealth (Employee Share)</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['philhealth']['employee_share'], 2) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">PhilHealth (Employer Share)</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['philhealth']['employer_share'], 2) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">SSS Contribution (Employee Share)</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['sssContribution']['employee_share'], 2) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">SSS Contribution (Employer Share)</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['sssContribution']['employer_share'], 2) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">Pag-IBIG (Employee Share)</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['pagibig']['employee_share'], 2) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">Pag-IBIG (Employer Share)</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['pagibig']['employer_share'], 2) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">Tax</td>
                <td class="border px-4 py-2">{{ number_format($payrollData['tax'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('payroll.records') }}" class="btn btn-secondary">Back to Payroll Records</a>

        <form action="{{ route('payroll.finalize', $employee->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">Finalize Payroll</button>
        </form>
    </div>
</div>
@endsection
