<div class="space-y-6">
    <!-- Header -->
    <div class="flex container min-w-full bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800">Create Adjustment</h1>
    </div>

    <!-- Form Container -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Adjustment Fields -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Adjustment Type -->
                <div>
                    <label for="adjustment" class="block text-sm font-medium text-gray-700">Adjustment Type</label>
                    <input type="text" id="adjustment" wire:model="adjustment"
                           class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Philhealth, Allowance, Bonus..."
                    @error('adjustment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Operation -->
                <div>
                    <label for="operation" class="block text-sm font-medium text-gray-700">Operation</label>
                    <select id="operation" wire:model="operation"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Operation</option>
                        <option value="incentive">Incentive</option>
                        <option value="deduction">Deduction</option>
                        <option value="contribution">Contribution</option>
                    </select>
                    @error('operation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Range Fields -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Range Start -->
                <div>
                    <label for="rangestart" class="block text-sm font-medium text-gray-700">Range Start</label>
                    <input type="text" id="rangestart" wire:model="rangestart"
                           class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Minimum value">
                    @error('rangestart') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Range End -->
                <div>
                    <label for="rangeend" class="block text-sm font-medium text-gray-700">Range End</label>
                    <input type="text" id="rangeend" wire:model="rangeend"
                           class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Maximum value">
                    @error('rangeend') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Amount Type Tabs -->
            <div x-data="{ activeTab: 'percentage' }" class="space-y-4">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button type="button"
                                @click="activeTab = 'percentage'; $wire.set('fixedamount', '')"
                                :class="{
                                    'border-indigo-500 text-indigo-600': activeTab === 'percentage',
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'percentage'
                                }"
                                class="p-2 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                            Percentage
                        </button>
                        <button type="button"
                                @click="activeTab = 'fixed'; $wire.set('percentage', '')"
                                :class="{
                                    'border-indigo-500 text-indigo-600': activeTab === 'fixed',
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'fixed'
                                }"
                                class="p-2 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                            Fixed Amount
                        </button>
                    </nav>
                </div>

                <!-- Percentage Tab Content -->
                <div x-show="activeTab === 'percentage'" x-transition.opacity class="space-y-4">
                    <div>
                        <label for="percentage" class="block text-sm font-medium text-gray-700">Percentage (%)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" id="percentage" wire:model.lazy="percentage"
                                   class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-10"
                                   placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">%</span>
                            </div>
                        </div>
                        @error('percentage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Fixed Amount Tab Content -->
                <div x-show="activeTab === 'fixed'" x-transition.opacity class="space-y-4">
                    <div>
                        <label for="fixedamount" class="block text-sm font-medium text-gray-700">Fixed Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="text" id="fixedamount" wire:model.lazy="fixedamount"
                                   class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-7"
                                   placeholder="0.00">
                        </div>
                        @error('fixedamount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    Create Adjustment
                </button>
            </div>
        </form>
    </div>
</div>
