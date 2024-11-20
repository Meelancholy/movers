<div class="min-h-full bg-white p-4 sm:p-6 rounded-lg shadow-md">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl sm:text-4xl font-bold text-gray-800 mb-4 sm:mb-0">Compensation Management</h1>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('compensation.create_deduction') }}" class="bg-blue-600 text-white font-semibold px-4 py-2 sm:px-5 sm:py-3 rounded-full shadow hover:bg-blue-700 transition transform hover:scale-105 duration-200 ease-in-out text-center">
                Add Deduction
            </a>
            <a href="{{ route('compensation.create_bonus') }}" class="bg-blue-600 text-white font-semibold px-4 py-2 sm:px-5 sm:py-3 rounded-full shadow hover:bg-blue-700 transition transform hover:scale-105 duration-200 ease-in-out text-center">
                Add Incentives
            </a>
            @livewire('compensation-and-benefits.add-deduction-modal')
        </div>
    </div>
    <form method="GET" class="mb-8" wire:submit.prevent="searchEmployees">
        <div class="flex items-center justify-between w-full">
            <!-- Left-aligned Filters -->
            <div class="flex">
                <div class="flex items-center border border-gray-300 rounded-l-full py-2 pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" wire:model="search" placeholder="Search Employees..." class="form-input focus:outline-none w-64" />
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-10 py-2 rounded-r-full transition shadow-lg">
                    Search
                </button>
            </div>
        </div>
    </form>
    @if(session('success'))
        <div class="mb-5 relative w-full overflow-hidden rounded-md border border-green-500 bg-white text-neutral-600 text-black" role="alert">
            <div class="flex w-full items-center gap-2 bg-green-500/10 p-4">
                <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-green-500">Success</h3>
                    <p class="text-xs font-medium sm:text-sm">{{ session('success') }}</p>
                </div>
                <button class="ml-auto" aria-label="dismiss alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="#000000" fill="none" stroke-width="2.5" class="w-4 h-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-3 sm:px-6 py-4 text-left text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider">Employee ID</th>
                    <th class="px-3 sm:px-6 py-4 text-left text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider">Employee</th>
                    <th class="px-3 sm:px-6 py-4 text-left text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider">Social Benefits</th>
                    <th class="px-3 sm:px-6 py-4 text-left text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider">Total Deductions</th>
                    <th class="px-3 sm:px-6 py-4 text-left text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider">Total Incentives</th>
                    <th class="px-3 sm:px-6 py-4 text-left text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider flex justify-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-200">
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-3 sm:px-6 py-4 text-xs sm:text-base font-medium text-gray-900">{{ $employee->id }}</td>
                        <td class="px-3 sm:px-6 py-4 text-xs sm:text-base font-medium text-gray-900"><strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></td>
                        <td class="px-3 sm:px-6 py-4 text-xs sm:text-base">
                            @if($employee->contributions->isNotEmpty())
                                <div class="flex space-x-2">
                                    @php
                                        $contribution = $employee->contributions->first();
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 sm:w-6 sm:h-6 rounded-full {{ $contribution->philhealth ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="ml-1">PhilHealth</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 sm:w-6 sm:h-6 rounded-full {{ $contribution->sss ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="ml-1">SSS</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 sm:w-6 sm:h-6 rounded-full {{ $contribution->pagibig ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="ml-1">Pag-IBIG</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-gray-500">No Contributions</div>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-4 text-xs sm:text-base text-orange-600 font-semibold"><strong>₱{{ number_format($employee->deductions->sum('amount'), 2) }}</strong></td>
                        <td class="px-3 sm:px-6 py-4 text-xs sm:text-base text-blue-600 font-semibold"><strong>₱{{ number_format($employee->bonuses->sum('amount'), 2) }}</strong></td>
                        <td class="px-3 sm:px-6 py-4 flex justify-center space-x-4">
                            <a href="{{ route('compensation.view', $employee->id) }}" class="bg-green-400 hover:bg-green-500 text-white px-2 py-1 sm:px-4 sm:py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" sm:width="24" sm:height="24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="7" r="4"/><path d="M10.3 15H7a4 4 0 0 0-4 4v2"/><circle cx="17" cy="17" r="3"/><path d="m21 21-1.9-1.9"/></svg>
                           </a>
                            <a href="{{ route('compensation.edit', $employee->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 sm:px-4 sm:py-2 rounded-full transition transform hover:scale-105 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" sm:width="24" sm:height="24" fill="none" stroke="#ffffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M11.5 15H7a4 4 0 0 0-4 4v2"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="7" r="4"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $employees->links() }}
    </div>
</div>
