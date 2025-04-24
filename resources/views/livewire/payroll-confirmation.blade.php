<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
        @if($type === 'individual')
            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Individual Payroll Summary
        @else
            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Bulk Payroll Summary
        @endif
    </h2>

    <!-- Summary Card -->
    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-blue-800 mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Payroll Overview
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Payroll Cycle:</span>
                    <span class="font-medium">{{ $summary['cycle'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Department:</span>
                    <span class="font-medium">{{ $summary['department'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Position:</span>
                    <span class="font-medium">{{ $summary['position'] }}</span>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Employees:</span>
                    <span class="font-medium">{{ $summary['employee_count'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Hours:</span>
                    <span class="font-medium">{{ $summary['total_hours'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Estimated Total:</span>
                    <span class="font-medium">PHP {{ $summary['estimated_total'] }}</span>
                </div>
            </div>
        </div>

        @if($type === 'individual')
        <div class="mt-4 pt-4 border-t border-blue-100">
            <div class="flex justify-between">
                <span class="text-gray-600">Employee Name:</span>
                <span class="font-medium">{{ $summary['employee_name'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Hourly Rate:</span>
                <span class="font-medium">PHP {{ $summary['hourly_rate'] }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Employee List (for bulk) -->
    @if($type === 'bulk' && $summary['employee_count'] > 0)
    <div class="mb-6">
        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Employees Included ({{ min($summary['employee_count'], 5) }} of {{ $summary['employee_count'] }})
        </h3>
        <div class="border rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($employees->take(5) as $employee)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $employee->department }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $employee->position }}</td>
                    </tr>
                    @endforeach
                    @if($summary['employee_count'] > 5)
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500">
                            + {{ $summary['employee_count'] - 5 }} more employees
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex justify-between pt-4 border-t">
        <button wire:click="cancel"
                class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancel
        </button>
        <button wire:click="confirm"
                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Confirm & Generate
        </button>
    </div>
</div>
