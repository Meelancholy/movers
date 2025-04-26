<div class="">
    <div class="">
        <div class="bg-white flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 p-6 rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Payroll Records</h1>

            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <!-- Cycle Filter -->
                <div class="w-full md:w-48">
                    <label for="cycleFilter" class="block text-sm font-medium text-gray-700 mb-1">Payroll Cycle</label>
                    <select
                        wire:model="selectedCycleId"
                        id="cycleFilter"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">All Cycles</option>
                        @foreach($cycles as $cycle)
                        <option value="{{ $cycle->id }}">
                            {{ $cycle->start_date->format('M d, Y') }} - {{ $cycle->end_date->format('M d, Y') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div class="w-full md:w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input
                        type="text"
                        wire:model.debounce.300ms="search"
                        id="search"
                        placeholder="Search employees..."
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white p-3 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('employee_id')">
                            Employee
                            @if($sortField === 'employee_id')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('cycle_id')">
                            Payroll Cycle
                            @if($sortField === 'cycle_id')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('base_pay')">
                            Base Pay
                            @if($sortField === 'base_pay')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Adjustments
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('net_pay')">
                            Net Pay
                            @if($sortField === 'net_pay')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            Generated On
                            @if($sortField === 'created_at')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payrolls as $payroll)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-600">{{ substr($payroll->employee->first_name, 0, 1) }}{{ substr($payroll->employee->last_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $payroll->employee->department }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $payroll->cycle->start_date->format('M d, Y') }} - {{ $payroll->cycle->end_date->format('M d, Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Cut-off: {{ $payroll->cycle->cut_off_date->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            PHP {{ number_format($payroll->base_pay, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                @php
                                    $totalAdjustments = 0;
                                    foreach ($payroll->payrollAdjustments as $adjustment) {
                                        $amount = $adjustment->type === 'incentive' ? $adjustment->amount : -$adjustment->amount;
                                        $totalAdjustments += $amount;
                                    }
                                    $finalTotal = $totalAdjustments - $payroll->tax;
                                @endphp

                                PHP {{ number_format($finalTotal, 2) }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            PHP {{ number_format($payroll->net_pay, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payroll->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a
                                    href="{{ route('payroll.download', $payroll->id) }}"
                                    class="text-blue-600 hover:text-blue-900"
                                    target="_blank"
                                >
                                    Download
                                </a>
                                <button
                                wire:click="$dispatch('showPayrollDetails', {payrollId: {{ $payroll->id }} })"
                                class="text-indigo-600 hover:text-indigo-900"
                            >
                                Details
                            </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No payroll records found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $payrolls->links() }}
        </div>
    </div>

    <!-- Payroll Details Modal -->
    @livewire('payroll-details-modal')
</div>
