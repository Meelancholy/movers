<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
        @if($type === 'individual')
            Individual Payroll Summary
        @else
            Bulk Payroll Summary ({{ $employees->count() }} Employees)
        @endif
    </h2>

    <!-- Cycle Summary -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="text-gray-600">Payroll Cycle:</span>
                <span class="font-medium block">{{ $summary['cycle'] }}</span>
            </div>
            <div>
                <span class="text-gray-600">Department:</span>
                <span class="font-medium block">{{ $summary['department'] }}</span>
            </div>
            <div>
                <span class="text-gray-600">Position:</span>
                <span class="font-medium block">{{ $summary['position'] }}</span>
            </div>
        </div>
    </div>

    @if($type === 'individual')
    <!-- Individual Employee Detail -->
    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-lg text-blue-800">
                {{ $summary['employee_name'] }}
            </h3>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                {{ $employee->department }} / {{ $employee->position }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
            <div class="bg-white p-3 rounded border">
                <div class="text-gray-500 text-sm">Hours Worked</div>
                <div class="text-xl font-bold">{{ $summary['total_hours'] }}</div>
            </div>
            <div class="bg-white p-3 rounded border">
                <div class="text-gray-500 text-sm">Hourly Rate</div>
                <div class="text-xl font-bold">PHP {{ $summary['hourly_rate'] }}</div>
            </div>
            <div class="bg-white p-3 rounded border">
                <div class="text-gray-500 text-sm">Base Pay</div>
                <div class="text-xl font-bold">PHP {{ $summary['base_pay'] }}</div>
            </div>
            <div class="bg-white p-3 rounded border">
                <div class="text-gray-500 text-sm">Estimated Pay</div>
                <div class="text-xl font-bold text-green-600">PHP {{ $summary['estimated_total'] }}</div>
            </div>
            <div class="bg-white p-3 rounded border">
                <div class="text-gray-500 text-sm">Estimated Tax</div>
                <div class="text-xl font-bold text-red-600">PHP {{ $summary['tax']}}</div>
            </div>
        </div>

        <!-- Adjustments Section -->
        <div class="mt-4">
            <h4 class="font-medium text-gray-700 mb-2">Adjustments to be Applied:</h4>
            <div class="bg-white border rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Adjustment</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Amount</th>
                            <th class="px-4 py-2 text-left">Frequency</th>
                            <th class="px-4 py-2 text-left">After Processing</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($summary['adjustments'] as $adjustment)
                        <tr>
                            <td class="px-4 py-2">{{ $adjustment['name'] }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $adjustment['type'] === 'addition' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($adjustment['type']) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 {{ $adjustment['type'] === 'addition' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $adjustment['type'] === 'addition' ? '+' : '-' }} PHP {{ number_format($adjustment['amount'], 2) }}
                            </td>
                            <td class="px-4 py-2">{{ $adjustment['frequency'] == -1 ? 'Infinite' : $adjustment['frequency'] }}</td>
                            <td class="px-4 py-2">
                                @if($adjustment['frequency'] == -1)
                                    Infinite (no change)
                                @else
                                    {{ max(0, $adjustment['frequency'] - 1) }}
                                    @if($adjustment['frequency'] - 1 <= 0)
                                        (will be removed)
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <!-- Bulk Employee Details -->
    <div class="space-y-4 mb-6">
        @foreach($employees as $employee)
        <div class="border rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b flex items-center justify-between">
                <div class="flex items-center">
                    <div class="font-medium">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                    <div class="ml-3 text-sm text-gray-500">
                        {{ $employee->department }} / {{ $employee->position }}
                    </div>
                </div>
                <div class="text-sm">
                    <span class="font-medium">ID:</span> {{ $employee->id }}
                </div>
            </div>

            <div class="bg-white p-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                    <div>
                        <div class="text-gray-500 text-sm">Hours Worked</div>
                        <div class="text-lg font-medium">{{ $employee->summary['hours_worked'] }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Hourly Rate</div>
                        <div class="text-lg font-medium">PHP {{ $employee->summary['hourly_rate'] }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Base Pay</div>
                        <div class="text-lg font-medium">PHP {{ $employee->summary['base_pay'] }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Estimated Pay</div>
                        <div class="text-lg font-medium text-green-600">PHP {{ $employee->summary['estimated_pay'] }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Estimated Tax</div>
                        <div class="text-lg font-medium text-red-600">PHP {{ $employee->summary['tax'] }}</div>
                    </div>
                </div>

                <!-- Adjustments Section -->
                <div class="mt-3 pt-3 border-t">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Adjustments:</h4>
                    <div class="space-y-2">
                        @foreach($employee->summary['adjustments'] as $adjustment)
                        <div class="flex justify-between text-sm">
                            <span>
                                {{ $adjustment['name'] }}
                                <span class="text-xs text-gray-500">
                                    (Current: {{ $adjustment['frequency'] == -1 ? '∞' : $adjustment['frequency'] }})
                                </span>
                            </span>
                            <span class="{{ $adjustment['type'] === 'addition' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $adjustment['type'] === 'addition' ? '+' : '-' }} PHP {{ number_format($adjustment['amount'], 2) }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 ml-2 mb-2">
                            After processing:
                            @if($adjustment['frequency'] == -1)
                                ∞ (no change)
                            @else
                                {{ max(0, $adjustment['frequency'] - 1) }}
                                @if($adjustment['frequency'] - 1 <= 0)
                                    (will be removed)
                                @endif
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Bulk Summary Footer -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="text-gray-600">Total Employees</div>
                <div class="text-xl font-bold">{{ $employees->count() }}</div>
            </div>
            <div>
                <div class="text-gray-600">Combined Hours</div>
                <div class="text-xl font-bold">{{ $summary['total_hours'] }}</div>
            </div>
            <div>
                <div class="text-gray-600">Total Estimated Payroll</div>
                <div class="text-xl font-bold text-green-600">PHP {{ $summary['estimated_total'] }}</div>
            </div>
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
            Confirm & Generate Payrolls
        </button>
    </div>
</div>
