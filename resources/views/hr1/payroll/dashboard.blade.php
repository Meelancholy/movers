{{-- In resources/views/hr1/payroll/dashboard.blade.php --}}

@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container min-w-full">
    <h1 class="text-3xl font-bold text-2D3748 mb-8">Payroll Dashboard</h1>
    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- Total Payrolls Card -->
        <div class="bg-blue-100 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-3182CE">Total Payrolls</h2>
            <p class="text-3xl text-4A5568">{{ $totalPayrolls }}</p>
        </div>

        <!-- Total Gross Salary Card -->
        <div class="bg-green-100 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-48BB78">Total Gross Salary</h2>
            <p class="text-3xl text-4A5568">₱{{ number_format($totalGrossSalary, 2) }}</p>
        </div>

        <!-- Total Net Salary Card -->
        <div class="bg-red-100 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-F56565">Total Net Salary</h2>
            <p class="text-3xl text-4A5568">₱{{ number_format($totalNetSalary, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="p-5 rounded-lg flex items-center justify-center">
            <a href="{{ route('payroll.generate') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition w-full text-center">
                Generate Payroll
            </a>
        </div>
        <div class="p-5 rounded-lg flex items-center justify-center">
            <a href="{{ route('payroll.records') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition w-full text-center">
                View Payroll Records
            </a>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-2D3748 mb-4">Recent Payrolls</h2>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <table class="w-full bg-white border-collapse">
            <thead class="bg-blue-100 text-2D3748">
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
