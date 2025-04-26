
<div>
    <!-- Modal Background -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" wire:click="close"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <!-- Modal Content -->
            <div class="">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Payroll Details - {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Employee Info -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Employee Information</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="grid grid-cols-1 gap-2">
                                            <div>
                                                <span class="text-sm text-gray-500">Name:</span>
                                                <span class="text-sm font-medium">{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Department:</span>
                                                <span class="text-sm font-medium">{{ $payroll->employee->department }}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Position:</span>
                                                <span class="text-sm font-medium">{{ $payroll->employee->position }}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Employee ID:</span>
                                                <span class="text-sm font-medium">{{ $payroll->employee->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payroll Info -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Payroll Information</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="grid grid-cols-1 gap-2">
                                            <div>
                                                <span class="text-sm text-gray-500">Cycle:</span>
                                                <span class="text-sm font-medium">
                                                    {{ $payroll->cycle->start_date->format('M d, Y') }} - {{ $payroll->cycle->end_date->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Status:</span>
                                                <span class="text-sm font-medium capitalize">{{ $payroll->status }}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Generated On:</span>
                                                <span class="text-sm font-medium">{{ $payroll->created_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Hours Worked:</span>
                                                <span class="text-sm font-medium">{{ $payroll->hours_worked }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payroll Breakdown -->
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-2">Payroll Breakdown</h4>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm">Base Pay:</span>
                                                <span class="text-sm font-medium">PHP {{ number_format($payroll->base_pay, 2) }}</span>
                                            </div>

                                            @if($payroll->payrollAdjustments->where('type', 'incentive')->count() > 0)
                                            <div class="ml-4">
                                                <div class="text-xs text-gray-500 mb-1">Incentives:</div>
                                                @foreach($payroll->payrollAdjustments->where('type', 'incentive') as $adjustment)
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-green-600">{{ $adjustment->adjustment->adjustment ?? json_decode($adjustment->adjustment_data)->name }}:</span>
                                                    <span class="text-green-600">+ PHP {{ number_format($adjustment->amount, 2) }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>

                                        <div>
                                            @if($payroll->payrollAdjustments->whereIn('type', ['deduction', 'contribution'])->count() > 0)
                                            <div class="text-xs text-gray-500 mb-1">Deductions:</div>
                                            @foreach($payroll->payrollAdjustments->whereIn('type', ['deduction', 'contribution']) as $adjustment)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-red-600">{{ $adjustment->adjustment->adjustment ?? json_decode($adjustment->adjustment_data)->name }}:</span>
                                                <span class="text-red-600">- PHP {{ number_format($adjustment->amount, 2) }}</span>
                                            </div>
                                            @endforeach
                                            @endif

                                            <div class="border-t mt-2 pt-2">
                                                <div class="flex justify-between font-medium">
                                                    <span>Net Pay:</span>
                                                    <span>PHP {{ number_format($payroll->net_pay, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Adjustment Details -->
                            @if($payroll->payrollAdjustments->count() > 0)
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-2">Adjustment Details</h4>
                                <div class="bg-white border rounded-lg overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Adjustment</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Frequency</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($payroll->payrollAdjustments as $adjustment)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                    {{ $adjustment->adjustment->name ?? json_decode($adjustment->adjustment_data)->name }}
                                                </td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                    <span class="px-2 py-1 text-xs rounded-full
                                                        {{ $adjustment->type === 'incentive' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ucfirst($adjustment->type) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm
                                                    {{ $adjustment->type === 'incentive' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $adjustment->type === 'incentive' ? '+' : '-' }} PHP {{ number_format($adjustment->amount, 2) }}
                                                </td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                    @if($adjustment->frequency_after == -1)
                                                        Infinite
                                                    @else
                                                        {{ $adjustment->frequency_before }} → {{ $adjustment->frequency_after }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Only change the close button at the bottom -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            wire:click="close"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
