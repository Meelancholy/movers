@extends('hr1.layouts.app')

@section('content')
    <!-- Single root element -->
    <div class="content-wrapper">
        <div class="content bg-gray">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                <!-- Card 1: Employees Overview -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <div class="flex items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Employees Overview</h2>
                    </div>
                    <p class="text-gray-600">Total Employees: <span class="font-bold">120</span></p>
                    <p class="text-gray-600">Active Employees: <span class="font-bold">110</span></p>
                    <p class="text-gray-600">On Leave: <span class="font-bold">10</span></p>

                    <!-- Progress Bar for Active Employees -->
                    <div class="relative pt-1 mt-4">
                        <div class="flex mb-2 items-center justify-between">
                            <span class="text-sm font-medium text-blue-600">Active Employees</span>
                            <span class="text-sm font-medium text-blue-600">{{ number_format((110 / 120) * 100, 2) }}%</span>
                        </div>
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-blue-200">
                            <div style="width:{{ (110 / 120) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Drivers Overview -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <div class="flex items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Drivers Overview</h2>
                    </div>
                    <p class="text-gray-600">Total Drivers: <span class="font-bold">80</span></p>
                    <p class="text-gray-600">Active Drivers: <span class="font-bold">48</span></p>
                    <p class="text-gray-600">Resting Drivers: <span class="font-bold">32</span></p>

                    <!-- Progress Bar for Active Drivers -->
                    <div class="relative pt-1 mt-4">
                        <div class="flex mb-2 items-center justify-between">
                            <span class="text-sm font-medium text-green-600">Active Drivers</span>
                            <span class="text-sm font-medium text-green-600">{{ number_format((48 / 80) * 100, 2) }}%</span>
                        </div>
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-green-200">
                            <div style="width:{{ (48 / 80) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-600"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Vehicles Overview -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <div class="flex items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Vehicles Overview</h2>
                    </div>
                    <ul class="text-gray-600">
                        <li>Total Vehicles: <span class="font-bold">50</span></li>
                        <li>Active Vehicles: <span class="font-bold">48</span></li>
                        <li>Unused Vehicles: <span class="font-bold">2</span></li>
                    </ul>

                    <!-- Progress Bar for Active Vehicles -->
                    <div class="relative pt-1 mt-4">
                        <div class="flex mb-2 items-center justify-between">
                            <span class="text-sm font-medium text-yellow-500">Active Vehicles</span>
                            <span class="text-sm font-medium text-yellow-500">{{ number_format((48 / 50) * 100, 2) }}%</span>
                        </div>
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-yellow-200">
                            <div style="width:{{ (48 / 50) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-yellow-600"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Separate Div for Recent Activity and Alerts -->
            <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">
                <!-- Card 4: Recent Activity -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h2>
                    <ul class="text-gray-600">
                        <li class="mb-2">New employee hired: John Doe (Sep 15, 2024)</li>
                        <li class="mb-2">Driver license renewed: Jane Smith (Sep 12, 2024)</li>
                        <li class="mb-2">Vehicle maintenance completed: Vehicle ID #432 (Sep 10, 2024)</li>
                    </ul>
                </div>

                <!-- Card 5: Alerts and Notifications -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Alerts & Notifications</h2>
                    <ul class="text-gray-600">
                        <li class="flex justify-between mb-2">
                            <span>Driver License Expiring: Mark White</span>
                            <span class="text-red-500">In 5 days</span>
                        </li>
                        <li class="flex justify-between mb-2">
                            <span>Payroll Approval Pending</span>
                            <span class="text-yellow-500">Due in 2 days</span>
                        </li>
                        <li class="flex justify-between mb-2">
                            <span>Vehicle Maintenance Required: Vehicle ID #123</span>
                            <span class="text-red-500">Overdue</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
