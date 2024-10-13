@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container mx-auto">
    <!-- Title Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Payroll Records</h1>

    <!-- Search by Employee Name -->
    <div class="mb-8">
        <form action="{{ route('payroll.records') }}" method="GET">
            <label for="employee_search" class="block text-lg font-medium text-gray-700 mb-2">Search by Employee Name</label>
            <input type="text" name="employee_name" id="employee_search" class="w-full border border-gray-300 p-3 rounded-lg" placeholder="Enter employee name...">
        </form>
    </div>

    <!-- Payroll Records Table -->
    <div class="overflow-hidden rounded-xl shadow-lg">
        <table class="w-full bg-white border-collapse">
            <thead class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                <tr>
                    <th class="p-4 text-left">Employee Name</th>
                    <th class="p-4 text-left">Salary</th>
                    <th class="p-4 text-left">Bonus/Allowance</th>
                    <th class="p-4 text-left">Deductions</th>
                    <th class="p-4 text-left">Benefits</th>
                    <th class="p-4 text-left">Net Pay</th>
                    <th class="p-4 text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $payroll)
                    <tr class="hover:bg-gray-100">
                        <td class="p-4">{{ $payroll->employee->name }}</td>
                        <td class="p-4">₱{{ number_format($payroll->salary, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->bonus, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->deductions, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->benefits, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->net_pay, 2) }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('payroll.show', $payroll->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-full hover:bg-blue-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Transactions -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Transactions</h2>
        <ul class="list-disc list-inside">
            @foreach($recentTransactions as $transaction)
                <li>
                    Payroll for {{ $transaction->employee->name }} processed on {{ $transaction->created_at->format('M d, Y') }}.
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
