@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container min-w-full">
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
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="p-4 text-left">Employee ID</th> <!-- Added Employee ID column -->
                    <th class="p-4 text-left">Employee Name</th>
                    <th class="p-4 text-left">Salary</th>
                    <th class="p-4 text-left">Gross Salary</th>
                    <th class="p-4 text-left">Withholdings</th>
                    <th class="p-4 text-left">Net Salary</th>
                    <th class="p-4 text-left">Date and Time</th>
                    <th class="p-4 text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $payroll)
                    <tr class="hover:bg-gray-100">
                        <td class="p-4">{{ $payroll->employee->id }}</td> <!-- Display Employee ID -->
                        <td class="p-4">{{ $payroll->employee->first_name . ' ' . $payroll->employee->last_name }}</td>
                        <td class="p-4">₱{{ number_format($payroll->salary, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->gross_salary, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->withholdings, 2) }}</td>
                        <td class="p-4">₱{{ number_format($payroll->net_salary, 2) }}</td>
                        <td class="p-4">{{ $payroll->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="p-4 text-center">
                            <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded-full hover:bg-blue-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
