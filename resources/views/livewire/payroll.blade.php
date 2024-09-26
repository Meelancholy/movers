@extends('hr1.layouts.app')
@section('content')
<section class="container mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-bold">Payroll Overview</h2>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Generate Payroll</a>
    </div>

    <!-- Search Payroll -->
    <div class="mb-6">
        <input type="text" placeholder="Search Payroll by Employee or Payroll ID..." class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" id="payrollSearch">
    </div>

    <!-- Payroll Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full table-auto" id="payrollTable">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Payroll ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Employee Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Pay Period</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Gross Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Deductions</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Net Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">John Doe</td>
                    <td class="px-6 py-4">01-Sep-2024 to 15-Sep-2024</td>
                    <td class="px-6 py-4">$5,000</td>
                    <td class="px-6 py-4">$500</td>
                    <td class="px-6 py-4">$4,500</td>
                    <td class="px-6 py-4">
                        <a href="#" class="text-blue-600 hover:underline">View</a> |
                        <a href="#" class="text-red-600 hover:underline">Edit</a> |
                        <a href="#" class="text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
                <!-- More payroll rows can go here -->
            </tbody>
        </table>
    </div>
</section>
@endsection
