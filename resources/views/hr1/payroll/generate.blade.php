@extends('hr1.layouts.app')

@section('content')
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
            @foreach($employeePayrollData as $employee)
                <tr class="hover:bg-gray-100">
                    <td class="p-4">{{ $employee['id'] }}</td>
                    <td class="p-4">{{ $employee['name'] }}</td>
                    <td class="p-4">₱{{ number_format($employee['baseSalary'], 2) }}</td>
                    <td class="p-4">₱{{ number_format($employee['totalBonus'], 2) }}</td>
                    <td class="p-4">₱{{ number_format($employee['deductions'], 2) }}</td>
                    <td class="p-4">₱{{ number_format($employee['benefits'], 2) }}</td>
                    <td class="p-4">₱{{ number_format($employee['netSalary'], 2) }}</td>
                    <td class="p-4 text-center">
                        <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded-full hover:bg-blue-600">View</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
