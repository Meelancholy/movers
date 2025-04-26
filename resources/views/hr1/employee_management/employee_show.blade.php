@extends('hr1.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold bg-white rounded-lg shadow-md mx-auto mt-6 p-8 mb-6">Employee Details: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <div class="space-y-6 bg-white rounded-lg shadow-md mx-auto p-8">
        <!-- Basic Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- First Name -->
            <div>
                <label class="block text-lg font-semibold mb-2">First Name</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ $employee->first_name }}
                </div>
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-lg font-semibold mb-2">Last Name</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ $employee->last_name }}
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-lg font-semibold mb-2">Status</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50 capitalize">
                    {{ $employee->status }}
                </div>
            </div>

            <!-- Contact -->
            <div>
                <label class="block text-lg font-semibold mb-2">Contact Number</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ $employee->contact }}
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-lg font-semibold mb-2">Email</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ $employee->email }}
                </div>
            </div>

            <!-- Department -->
            <div>
                <label class="block text-lg font-semibold mb-2">Department</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ $employee->department }}
                </div>
            </div>

            <!-- Position -->
            <div>
                <label class="block text-lg font-semibold mb-2">Position</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ $employee->position }}
                </div>
            </div>

            <!-- Birth Date -->
            <div>
                <label class="block text-lg font-semibold mb-2">Birth Date</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ \Carbon\Carbon::parse($employee->bdate)->format('m/d/Y') }}
                </div>
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-lg font-semibold mb-2">Gender</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50 capitalize">
                    {{ $employee->gender }}
                </div>
            </div>

            <!-- Job Type -->
            <div>
                <label class="block text-lg font-semibold mb-2">Job Type</label>
                <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                    {{ ucfirst($employee->job_type) }}
                </div>
            </div>
        </div>

        @php
            // Calculate hours worked and base salary
            $hours = $employee->attendances->sum('hours_worked');
            $rate = $employee->salary->hourly_rate ?? 0;
            $baseSalary = $hours * $rate;
        @endphp

        <!-- Attendance Summary -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Salary Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-lg font-semibold mb-2">Total Hours Worked</label>
                    <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                        {{ number_format($hours, 2) }} hours
                    </div>
                </div>
                <div>
                    <label class="block text-lg font-semibold mb-2">Hourly Rate</label>
                    <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                        ₱{{ number_format($rate, 2) }}
                    </div>
                </div>
                <div>
                    <label class="block text-lg font-semibold mb-2">Base Salary</label>
                    <div class="border border-gray-300 rounded-full px-4 py-2 w-full bg-gray-50">
                        ₱{{ number_format($baseSalary, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Adjustments Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Employee Adjustments</h2>

            @if($employee->adjustments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adjustment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Per Application</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Impact</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalImpact = 0;
                            @endphp
                            @foreach($employee->adjustments as $adjustment)
                                @php
                                    $pivot = $adjustment->pivot;
                                    $amount = 0;

                                    if ($adjustment->fixedamount) {
                                        $amount = $adjustment->fixedamount;
                                    } elseif ($adjustment->percentage) {
                                        $amount = $baseSalary * $adjustment->percentage / 100;
                                    }

                                    if ($adjustment->operation === 'subtract') {
                                        $amount *= -1;
                                    }

                                    $totalImpact += $amount * $pivot->frequency;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $adjustment->adjustment }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $adjustment->operation === 'add' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $adjustment->operation === 'add' ? 'Incentive' : 'Deduction' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($adjustment->fixedamount)
                                            ₱{{ number_format($adjustment->fixedamount, 2) }}
                                        @elseif($adjustment->percentage)
                                            {{ $adjustment->percentage }}%
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $pivot->frequency }}x
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $amount >= 0 ? '+' : '-' }}₱{{ number_format(abs($amount), 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ ($amount * $pivot->frequency) >= 0 ? '+' : '-' }}₱{{ number_format(abs($amount * $pivot->frequency), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50">
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-right font-semibold">Net Adjustments Impact:</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                    {{ $totalImpact >= 0 ? '+' : '-' }}₱{{ number_format(abs($totalImpact), 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="border border-gray-200 rounded-lg p-4 text-center text-gray-500">
                    No adjustments assigned to this employee.
                </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('employee.edit', $employee->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Edit Employee
            </a>
            <a href="{{ route('employee.list') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
