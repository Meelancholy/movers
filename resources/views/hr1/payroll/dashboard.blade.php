{{-- In resources/views/hr1/payroll/dashboard.blade.php --}}

@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container min-w-full">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Payroll Dashboard</h1>

    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- Total Payrolls Card -->
        <div class="bg-blue-100 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-blue-600">Total Payrolls</h2>
            <p class="text-3xl text-gray-800">{{ $totalPayrolls }}</p>
        </div>

        <!-- Total Gross Salary Card -->
        <div class="bg-green-100 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-green-600">Total Gross Salary</h2>
            <p class="text-3xl text-gray-800">₱{{ number_format($totalGrossSalary, 2) }}</p>
        </div>

        <!-- Total Net Salary Card -->
        <div class="bg-yellow-700 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-red-600">Total Net Salary</h2>
            <p class="text-3xl text-gray-800">₱{{ number_format($totalNetSalary, 2) }}</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Payrolls</h2>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <table class="w-full bg-white border-collapse">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="p-4 text-left">Employee Name</th>
                    <th class="p-4 text-left">Gross Salary</th>
                    <th class="p-4 text-left">Net Salary</th>
                    <th class="p-4 text-left">Date Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentPayrolls as $payroll)
                    <tr class="hover:bg-gray-100">
                        <td class="p-4">{{ $payroll->employee->first_name . ' ' . $payroll->employee->last_name }}</td>
                        <td class="p-4">₱{{ number_format($payroll->gross_salary, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->net_salary, 2) }}</td>
                        <td class="p-4">{{ $payroll->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
