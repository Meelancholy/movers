@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container mx-auto">
    <!-- Title Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Payroll Details</h1>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700">Employee Name:</h2>
            <p class="text-gray-600">{{ $payroll->employee->name }}</p>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-700">Employee ID:</h2>
            <p class="text-gray-600">{{ $payroll->employee->id }}</p>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-700">Base Salary:</h2>
            <p class="text-gray-600">₱{{ number_format($payroll->salary, 2) }}</p>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-700">Net Pay:</h2>
            <p class="text-gray-600">₱{{ number_format($payroll->net_pay, 2) }}</p>
        </div>
    </div>

    <div class="bg-gray-100 p-6 rounded-lg">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Payroll Breakdown</h3>
        <p><strong>Bonus/Allowance:</strong> ₱{{ number_format($payroll->bonus, 2) }}</p>
        <p><strong>Deductions:</strong> ₱{{ number_format($payroll->deductions, 2) }}</p>
        <p><strong>Benefits:</strong> ₱{{ number_format($payroll->benefits, 2) }}</p>
        <p><strong>Tax Deducted:</strong> ₱{{ number_format($payroll->salary - $payroll->net_pay + $payroll->bonus - $payroll->deductions + $payroll->benefits, 2) }}</p>
    </div>
</div>
@endsection
