@extends('hr1.layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Deduction, Bonus, and Allowance Management</h2>

        <!-- Add Deduction Form -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-4">Add Deduction/Bonus/Allowance</h3>
            <form id="addDeductionForm" onsubmit="addDeduction(event)">
                <div>
                    <div>
                        <label class="block font-medium mb-1">Employee Id</label>
                        <input type="number" id="employeeid" placeholder="Enter employee id" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <!-- Employee -->
                    <div class="col-span-2">
                        <label class="block font-medium mb-1">Employee Name</label>
                        <input type="text" id="allowanceEmployeeName" placeholder="Enter employee name" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>

                    <!-- Deduction -->
                    <div>
                        <label class="block font-medium mb-1">Amount</label>
                        <input type="number" id="deductionAmount" placeholder="Enter deduction amount" class="w-full p-2 border border-gray-300 rounded-md " required>
                    </div>

                    <div class="w-64">
                        <label for="options" class="block font-medium mb-1">Choose an option</label>
                        <select id="options" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="option1">Bonus</option>
                            <option value="option2">Deduction</option>
                            <option value="option3">Allowance</option>
                        </select>
                    </div>
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Add Deduction</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Search bar -->
        <div class="flex items-center space-x-4 mb-6">
            <input type="text" id="search" placeholder="Search by Payroll ID, Employee Name, or Period" class="w-full p-2 border border-gray-300 rounded-md">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md" onclick="filterRecords()">Search</button>
        </div>
        <!-- Payroll Records Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 text-left">Payroll ID</th>
                        <th class="py-2 px-4 text-left">Employee Name</th>
                        <th class="py-2 px-4 text-left">Period</th>
                        <th class="py-2 px-4 text-left">Deductions</th>
                        <th class="py-2 px-4 text-left">Bonuses</th>
                        <th class="py-2 px-4 text-left">Allowances</th>
                        <th class="py-2 px-4 text-left">Net Salary</th>
                    </tr>
                </thead>
                <tbody id="payroll-records" class="divide-y divide-gray-200">
                    <!-- Sample Data -->
                    <tr>
                        <td class="py-2 px-4">1</td>
                        <td class="py-2 px-4">John Doe</td>
                        <td class="py-2 px-4">01/09/2024 - 15/09/2024</td>
                        <td class="py-2 px-4">$300</td>
                        <td class="py-2 px-4">$100</td>
                        <td class="py-2 px-4">$50</td>
                        <td class="py-2 px-4">$1700</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
