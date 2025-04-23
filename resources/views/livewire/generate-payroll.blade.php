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
                            <button wire:click.stop="editCycle({{ $cycle->id }})"
                                    class="text-gray-400 hover:text-blue-500 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
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
            <div x-data="{
                selectedDepartment: '',
                selectedPosition: '',
                filterEmployees() {
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const department = row.querySelector('td:nth-child(2)').textContent.trim();
                        const position = row.querySelector('td:nth-child(3)').textContent.trim();

                        const departmentMatch = !this.selectedDepartment || department === this.selectedDepartment;
                        const positionMatch = !this.selectedPosition || position === this.selectedPosition;

                        row.style.display = (departmentMatch && positionMatch) ? '' : 'none';
                    });
                }
            }">
                <!-- Filter controls -->
                <div class="mb-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <h2 class="text-lg font-medium text-gray-900">Payroll Processing</h2>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Department Filter -->
                        <select wire:model="selectedDepartment"
                                id="department-filter"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Departments</option>
                            @foreach($employees->pluck('department')->unique()->sort() as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                        </select>

                        <!-- Position Filter -->
                        <select wire:model="selectedPosition"
                                id="position-filter"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Positions</option>
                            @foreach($employees->pluck('position')->unique()->sort() as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        </select>

                        <!-- Bulk Generate Button -->
                        @if($selectedCycle)
                            @php
                                $cutOffPassed = \Carbon\Carbon::parse($selectedCycle->cut_off_date)->isPast();
                                $hasUnprocessedEmployees = $employees->count() > $selectedCycle->payrolls->count();
                            @endphp

                            @if($cutOffPassed && $hasUnprocessedEmployees)
                                <div class="self-end">
                                    <button wire:click="prepareBulkGeneratePayroll"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        Generate Selected
                                    </button>
                                </div>
                            @elseif(!$cutOffPassed)
                                <span class="text-gray-500 text-sm italic">Wait for cut-off to generate payrolls</span>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Your table with filtered employees -->
                @if($selectedCycle)
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
    @if($showBulkGenerateConfirmation)
    <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
        <div class="fixed inset-0 transform transition-all" wire:click="showBulkGenerateConfirmation = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto sm:my-8">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900">Generate Payrolls for All Employees</h3>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        This will generate payroll for all employees who don't have one in the selected cycle.
                        Are you sure you want to continue?
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button wire:click="confirmBulkGeneratePayroll" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Generate All
                </button>
                <button wire:click="$set('showBulkGenerateConfirmation', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endif
    <!-- Edit Cycle Modal -->
    @if ($showEditModal)
    <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="font-bold text-lg mb-3">Edit Payroll Cycle</h3>

            @if($errors->has('overlap'))
                <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-md text-sm">
                    {{ $errors->first('overlap') }}
                </div>
            @endif

            <div class="space-y-4 mb-5">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input wire:model="form.start_date" type="date" id="start_date"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('form.start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input wire:model="form.end_date" type="date" id="end_date"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('form.end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="cut_off_date" class="block text-sm font-medium text-gray-700 mb-1">Cut-off Date</label>
                    <input wire:model="form.cut_off_date" type="date" id="cut_off_date"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('form.cut_off_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="payout_date" class="block text-sm font-medium text-gray-700 mb-1">Payout Date</label>
                    <input wire:model="form.payout_date" type="date" id="payout_date"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('form.payout_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button wire:click="$set('showEditModal', false)"
                        class="px-4 py-2 border rounded hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button wire:click="updateCycle"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Save Changes
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
