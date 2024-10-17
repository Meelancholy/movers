@extends('hr1.layouts.app')

@section('content')
<div class="mb-8 bg-white rounded-lg p-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Generate Payroll</h1>
    <table class="bg-white min-w-full border-collapse">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="p-4 text-left">Employee ID</th>
                <th class="p-4 text-left">Employee Name</th>
                <th class="p-4 text-left">Base Salary</th>
                <th class="p-4 text-left">Gross Salary</th>
                <th class="p-4 text-left">Witholdings</th>
                <th class="p-4 text-left">Net Salary</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employeePayrollData as $employee)
                <tr class="hover:bg-gray-100">
                    <td class="p-4">{{ $employee['id'] }}</td>
                    <td class="p-4 font-bold">{{ $employee['name'] }}</td>
                    <td class="p-4 text-blue-500 font-bold">₱{{ number_format($employee['baseSalary'], 2) }}</td>
                    <td class="p-4 text-green-500 font-bold">₱{{ number_format($employee['grossSalary'], 2) }}</td>
                    <td class="p-4 text-red-500 font-bold">₱{{ number_format($employee['withholdings'], 2) }}</td>
                    <td class="p-4 text-yellow-500 font-bold">₱{{ number_format($employee['netSalary'], 2) }}</td>
                    <td class="p-4 text-center">
                        <button type="button" class="bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">Generate</button>
                    <td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
