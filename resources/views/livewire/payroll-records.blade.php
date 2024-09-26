@extends('hr1.layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Salary and Payroll Records</h2>

        <!-- Search bar -->
        <div class="flex items-center space-x-4 mb-6">
            <input type="text" id="search" placeholder="Search by Payroll ID, Employee Name, or Period" class="w-full p-2 border border-gray-300 rounded-md">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md" onclick="filterRecords()">Search</button>
        </div>

        <!-- Payroll Records Table -->
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-blue-600 text-white ">
                        <th class="py-2 px-4 text-left">Payroll ID</th>
                        <th class="py-2 px-4 text-left">Employee Name</th>
                        <th class="py-2 px-4 text-left">Pay Period</th>
                        <th class="py-2 px-4 text-left">Gross Salary</th>
                        <th class="py-2 px-4 text-left">Deductions</th>
                        <th class="py-2 px-4 text-left">Net Salary</th>
                        <th class="py-2 px-4 text-left">Bonuses</th>
                        <th class="py-2 px-4 text-left">Allowances</th>
                    </tr>
                </thead>
                <tbody id="payroll-records" class="divide-y divide-gray-200">
                    <!-- Sample Data -->
                    <tr>
                        <td class="py-2 px-4">1</td>
                        <td class="py-2 px-4">John Doe</td>
                        <td class="py-2 px-4">01/09/2024 - 15/09/2024</td>
                        <td class="py-2 px-4">$2000</td>
                        <td class="py-2 px-4">$300</td>
                        <td class="py-2 px-4">$1700</td>
                        <td class="py-2 px-4">$100</td>
                        <td class="py-2 px-4">$50</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4">2</td>
                        <td class="py-2 px-4">Jane Smith</td>
                        <td class="py-2 px-4">01/09/2024 - 15/09/2024</td>
                        <td class="py-2 px-4">$2200</td>
                        <td class="py-2 px-4">$320</td>
                        <td class="py-2 px-4">$1880</td>
                        <td class="py-2 px-4">$150</td>
                        <td class="py-2 px-4">$70</td>
                    </tr>
                    <!-- Add more data here -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
