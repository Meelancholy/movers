<div class="">
    <!-- Header -->
    <div class="flex justify-between items-center mb-2 bg-white p-6 rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800">Payroll Management</h1>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Cycles Sidebar -->
        <div class="lg:w-1/4 bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Payroll Cycles</h2>
                <button wire:click="$toggle('showCreateCycleForm')"
                        class="p-1 text-blue-600 hover:bg-blue-50 rounded-full"
                        title="Add new cycle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Create Cycle Form -->
            @if ($showCreateCycleForm)
            <div class="mb-4 p-3 border rounded-lg bg-gray-50">
                <h3 class="font-medium mb-2">New Payroll Cycle</h3>
                <form wire:submit.prevent="createCycle">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input wire:model="newCycle.start_date" type="date"
                                   class="w-full p-2 border rounded text-sm">
                            @error('newCycle.start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input wire:model="newCycle.end_date" type="date"
                                   class="w-full p-2 border rounded text-sm">
                            @error('newCycle.end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cut-Off Date</label>
                            <input wire:model="newCycle.cut_off_date" type="date"
                                   class="w-full p-2 border rounded text-sm">
                            @error('newCycle.cut_off_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payout Date</label>
                            <input wire:model="newCycle.payout_date" type="date"
                                   class="w-full p-2 border rounded text-sm">
                            @error('newCycle.payout_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end space-x-2 pt-2">
                            <button type="button" wire:click="$toggle('showCreateCycleForm')"
                                    class="px-3 py-1 text-sm border rounded hover:bg-gray-100">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            <!-- Cycles List -->
            <div class="space-y-2 max-h-[500px] overflow-y-auto">
                @foreach ($cycles as $cycle)
                <div wire:click="selectCycle({{ $cycle->id }})"
                     class="p-3 border rounded-lg cursor-pointer transition-colors
                            {{ $selectedCycleId === $cycle->id ? 'bg-blue-50 border-blue-200' : 'hover:bg-gray-50' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-sm">
                                {{ $cycle->start_date->format('M d') }} - {{ $cycle->end_date->format('M d, Y') }}
                            </h3>
                            <div class="text-xs text-gray-500">
                                Cut-off: {{ $cycle->cut_off_date->format('M d, Y') }} |
                                Payout: {{ $cycle->payout_date->format('M d, Y') }}
                            </div>
                        </div>
                        <button wire:click.stop="confirmDeleteCycle({{ $cycle->id }})"
                                class="text-gray-400 hover:text-red-500 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Payroll Content -->
        <div class="lg:w-3/4 bg-white rounded-lg shadow p-4">
            @if (session('message'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if ($selectedCycle)
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">
                        {{ $selectedCycle->start_date->format('M d, Y') }} - {{ $selectedCycle->end_date->format('M d, Y') }}
                    </h2>
                    <div class="text-sm text-gray-500">
                        Cut-off: {{ $selectedCycle->cut_off_date->format('M d, Y') }} |
                        Payout: {{ $selectedCycle->payout_date->format('M d, Y') }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">Employee</th>
                                <th class="px-3 py-2 text-left">Department</th>
                                <th class="px-3 py-2 text-left">Position</th>
                                <th class="px-3 py-2 text-center">Status</th>
                                <th class="px-3 py-2 text-right">Amount</th>
                                <th class="px-3 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($employees as $employee)
                            @php
                                $payroll = $selectedCycle->payrolls->firstWhere('employee_id', $employee->id);
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $employee->department }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $employee->position }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @if($payroll)
                                        @if($payroll->status === 'paid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            Not Processed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right whitespace-nowrap">
                                    @if($payroll)
                                        PHP {{ number_format($payroll->net_pay, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right">
                                    @php
                                        $cutOffPassed = \Carbon\Carbon::parse($selectedCycle->cut_off_date)->isPast();
                                    @endphp

                                    @if ($payroll && $payroll->status === 'paid')
                                        <a wire:click="downloadPdf({{ $payroll->id }})"
                                           class="text-blue-600 hover:text-blue-800 text-sm flex items-center justify-end cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            PDF
                                        </a>
                                    @else
                                        @if ($cutOffPassed)
                                            <button wire:click="prepareGeneratePayroll({{ $employee->id }})"
                                                class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-right">
                                                Generate
                                            </button>
                                        @else
                                            <span class="text-gray-500 text-sm italic">Wait for cut-off</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>Please select a payroll cycle from the sidebar</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Cycle Modal -->
    @if ($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="font-bold text-lg mb-3">Confirm Deletion</h3>
            <p class="mb-5">Are you sure you want to delete this payroll cycle? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('showDeleteModal', false)"
                        class="px-4 py-2 border rounded hover:bg-gray-50">
                    Cancel
                </button>
                <button wire:click="deleteCycle"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Generate Payroll Modal -->
    @if ($showGenerateConfirmation)
    <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="font-bold text-lg mb-3">Confirm Payroll Generation</h3>
            <div class="mb-4">
                <p class="font-medium">{{ $employeeToGenerate->first_name }} {{ $employeeToGenerate->last_name }}</p>
                <p class="text-sm text-gray-600">{{ $employeeToGenerate->position }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded mb-4">
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>Hours Worked:</div>
                    <div class="text-right">{{ $calculatedPayroll['hours_worked'] }}</div>

                    <div>Base Pay:</div>
                    <div class="text-right">PHP {{ number_format($calculatedPayroll['base_pay'], 2) }}</div>

                    <div>Gross Pay:</div>
                    <div class="text-right">PHP {{ number_format($calculatedPayroll['gross_pay'], 2) }}</div>

                    <div>Deductions:</div>
                    <div class="text-right">PHP {{ number_format($calculatedPayroll['adjustments_total'], 2) }}</div>

                    <div class="font-bold">Net Pay:</div>
                    <div class="text-right font-bold">PHP {{ number_format($calculatedPayroll['net_pay'], 2) }}</div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button wire:click="$set('showGenerateConfirmation', false)"
                        class="px-4 py-2 border rounded hover:bg-gray-50">
                    Cancel
                </button>
                <button wire:click="confirmGeneratePayroll"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Confirm
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
