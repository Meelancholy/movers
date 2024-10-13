@extends('hr1.layouts.app')

@section('content')
    <div class="p-8 min-h-screen">
        <!-- Dashboard Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-5xl font-bold text-gray-900">Welcome Back!  </h1>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8 mb-10">
            <!-- Employees Card -->
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 p-6 rounded-lg shadow-lg flex items-center justify-between text-white">
                <div>
                    <h3 class="text-lg font-semibold">Total Employees</h3>
                    <p class="mt-2 text-5xl font-bold">120</p>
                </div>
                <div class="bg-white bg-opacity-30 p-4 rounded-full">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                </div>
            </div>

            <!-- Payroll Processed -->
            <div class="bg-gradient-to-r from-green-400 to-teal-500 p-6 rounded-lg shadow-lg flex items-center justify-between text-white">
                <div>
                    <h3 class="text-lg font-semibold">Monthly Payroll Processed</h3>
                    <p class="mt-2 text-5xl font-bold">₱ 1.25M</p>
                </div>
                <div class="bg-white bg-opacity-30 p-4 rounded-full">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h18v2H3V3zm0 6h12v2H3V9zm0 6h9v2H3v-2z"></path>
                    </svg>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6 rounded-lg shadow-lg flex items-center justify-between text-white">
                <div>
                    <h3 class="text-lg font-semibold">Pending Requests</h3>
                    <p class="mt-2 text-5xl font-bold">5</p>
                </div>
                <div class="bg-white bg-opacity-30 p-4 rounded-full">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12l-18 9v-18z"></path>
                    </svg>
                </div>
            </div>

            <!-- Open Positions -->
            <div class="bg-gradient-to-r from-red-400 to-pink-500 p-6 rounded-lg shadow-lg flex items-center justify-between text-white">
                <div>
                    <h3 class="text-lg font-semibold">Open Positions</h3>
                    <p class="mt-2 text-5xl font-bold">3</p>
                </div>
                <div class="bg-white bg-opacity-30 p-4 rounded-full">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l1.664 6h6.174l-4.85 3.61 1.664 6-4.85-3.61-4.85 3.61 1.664-6-4.85-3.61h6.174L12 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activities -->
            <div class="col-span-2 bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-gray-700 mb-6">Recent Employee Activities</h2>
                <ul class="space-y-6">
                    <li class="flex justify-between">
                        <span class="text-gray-600">John Doe added a new employee</span>
                        <span class="text-sm text-gray-500">2 hours ago</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Jane Smith updated payroll details</span>
                        <span class="text-sm text-gray-500">1 day ago</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Sarah Lee requested leave</span>
                        <span class="text-sm text-gray-500">3 days ago</span>
                    </li>
                </ul>
            </div>

            <!-- Payroll Summary (Chart Placeholder) -->
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-gray-700 mb-6">Payroll Summary</h2>
                <div class="h-44 bg-gradient-to-br from-gray-100 to-gray-50 rounded-lg flex items-center justify-center">
                    <!-- Placeholder for chart -->
                    <span class="text-gray-400">[Graph Placeholder]</span>
                </div>
            </div>
        </div>

        <!-- Employee Statistics (Optional Charts) -->
        <div class="mt-12 bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Employee Statistics</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Chart or Summary 1 -->
                <div class="bg-gradient-to-r from-blue-400 to-indigo-500 p-6 rounded-lg text-white flex items-center justify-center">
                    <span class="text-lg font-bold">[Chart Placeholder]</span>
                </div>

                <!-- Chart or Summary 2 -->
                <div class="bg-gradient-to-r from-teal-400 to-green-500 p-6 rounded-lg text-white flex items-center justify-center">
                    <span class="text-lg font-bold">[Chart Placeholder]</span>
                </div>
            </div>
        </div>
    </div>
@endsection
