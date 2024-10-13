@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container mx-auto">
    <!-- Title Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Generate Payroll</h1>

    <form action="{{ route('payroll.store') }}" method="POST">
        @csrf

        <!-- Employee Selection with Base Salary and Net Salary Computation -->
        <div class="mb-8">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="p-4 text-left">Employee ID</th>
                        <th class="p-4 text-left">Employee Name</th>
                        <th class="p-4 text-left">Base Salary</th>
                        <th class="p-4 text-left">Total Bonus/Allowance</th>
                        <th class="p-4 text-left">Deductions</th>
                        <th class="p-4 text-left">Employee Share of Benefits</th>
                        <th class="p-4 text-left">Net Salary</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        @php
                            // Calculate tax based on user-provided tax table
                            $baseSalary = $employee->position->base_salary;
                            $totalBonus = $employee->bonuses->sum('amount'); // Assuming the 'amount' field in bonuses table
                            $tax = 0;

                            if ($baseSalary > 666667) {
                                $tax = 200833.33 + ($baseSalary - 666667) * 0.35;
                            } elseif ($baseSalary > 166667) {
                                $tax = 40833.33 + ($baseSalary - 166667) * 0.30;
                            } elseif ($baseSalary > 66667) {
                                $tax = 10833.33 + ($baseSalary - 66667) * 0.25;
                            } elseif ($baseSalary > 33333) {
                                $tax = 2500 + ($baseSalary - 33333) * 0.20;
                            } elseif ($baseSalary > 20833) {
                                $tax = ($baseSalary - 20833) * 0.15;
                            }

                            // Net salary calculation (without deductions/benefits as inputs are removed)
                            $deductions = 0; // Set your logic to get deductions from another source if necessary
                            $benefits = 0; // Set your logic to get employee share of benefits if necessary
                            $netSalary = $baseSalary + $totalBonus - $tax - $deductions - $benefits;
                        @endphp
                        <tr class="hover:bg-gray-100">
                            <td class="p-4">{{ $employee->id }}</td>
                            <td class="p-4">{{ $employee->last_name }}, {{ $employee->first_name }}</td>
                            <td class="p-4">₱{{ number_format($baseSalary, 2) }}</td>
                            <td class="p-4">₱{{ number_format($totalBonus, 2) }}</td>
                            <td class="p-4">₱{{ number_format($deductions, 2) }}</td>
                            <td class="p-4">₱{{ number_format($benefits, 2) }}</td>
                            <td class="p-4">
                                <!-- Net Salary to be calculated -->
                                <span id="net_salary_{{ $employee->id }}">₱{{ number_format($netSalary, 2) }}</span>
                            </td>
                            <td class="p-4 text-center">
                                <!-- View Button -->
                                <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-full hover:bg-blue-600">View</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Generate Payroll Button -->
        <div class="text-right">
            <button type="submit" class="bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold py-3 px-6 rounded-full hover:from-green-600 hover:to-teal-700">
                Generate Payroll
            </button>
        </div>
    </form>
</div>
@endsection
