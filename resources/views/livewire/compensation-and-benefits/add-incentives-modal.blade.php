<div>
    <!-- Trigger Button -->
    <button wire:click="openModal" class="bg-blue-500 hover:bg-blue-600 w-full text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
        Add Incentives
    </button>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-lg w-96 p-6 shadow-lg">
                <h1 class="text-2xl font-bold mb-6">Add Incentives</h1>

                <!-- Bonus Form -->
                <form wire:submit.prevent="store" class="space-y-6">
                    @csrf
                    <div
                        x-data="{
                            allOptions: {{ Js::from($employees->map(fn($e) => ['label' => $e->first_name . ' ' . $e->last_name . ' (ID: ' . $e->id . ')', 'value' => $e->id])) }},
                            options: [],
                            isOpen: false,
                            openedWithKeyboard: false,
                            selectedOption: null,
                            setSelectedOption(option) {
                                this.selectedOption = option;
                                this.isOpen = false;
                                this.openedWithKeyboard = false;
                                this.$refs.hiddenTextField.value = option.value;
                                $wire.set('employee_id', option.value); // Connect to Livewire model
                            },
                            getFilteredOptions(query) {
                                this.options = this.allOptions.filter(option =>
                                    option.label.toLowerCase().includes(query.toLowerCase())
                                );
                                if (this.options.length === 0) {
                                    this.$refs.noResultsMessage.classList.remove('hidden');
                                } else {
                                    this.$refs.noResultsMessage.classList.add('hidden');
                                }
                            },
                            handleKeydownOnOptions(event) {
                                if ((event.keyCode >= 65 && event.keyCode <= 90) ||
                                    (event.keyCode >= 48 && event.keyCode <= 57) ||
                                    event.keyCode === 8) {
                                    this.$refs.searchField.focus();
                                }
                            },
                        }"
                        class="mb-6 relative"
                        x-init="options = allOptions"
                        >
                            <!-- Label -->
                            <label for="employee" class="text-lg font-semibold mb-2">Employee Name and ID</label>

                            <!-- Input Button -->
                            <button
                                type="button"
                                class="form-input flex items-center justify-between border border-gray-300 rounded-md px-5 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
                                role="combobox"
                                aria-controls="employeeList"
                                aria-haspopup="listbox"
                                x-on:click="isOpen = !isOpen"
                                x-bind:aria-expanded="isOpen || openedWithKeyboard"
                                x-bind:aria-label="selectedOption ? selectedOption.label : 'Please Select Employee'"
                            >
                                <!-- Placeholder or Selected Option -->
                                <span x-text="selectedOption ? selectedOption.label : 'Please Select Employee'" class="text-sm font-normal text-gray-600"></span>

                                <!-- Dropdown Icon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="w-5 h-5 text-gray-600 transition-transform duration-200 ease-in-out"
                                    x-bind:class="{'rotate-180': isOpen}"
                                >
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                </svg>
                            </button>


                            <!-- Hidden Field -->
                            <input type="hidden" x-ref="hiddenTextField" id="employee" wire:model="employee_id">

                            <!-- Dropdown -->
                            <div
                                x-show="isOpen || openedWithKeyboard"
                                id="employeeList"
                                class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-40 overflow-auto shadow-lg"
                                x-on:click.outside="isOpen = false, openedWithKeyboard = false"
                                x-transition
                            >
                                <!-- Search -->
                                <div class="relative">
                                    <input
                                        type="text"
                                        class="w-full border-b border-gray-300 py-2.5 pl-4 pr-4 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Search"
                                        x-ref="searchField"
                                        x-on:input="getFilteredOptions($el.value)"
                                    />
                                </div>
                                <ul class="flex flex-col max-h-40 overflow-y-auto">
                                    <li class="hidden px-4 py-2 text-gray-500" x-ref="noResultsMessage">
                                        <span>No matches found</span>
                                    </li>
                                    <template x-for="(item, index) in options" x-bind:key="item.value">
                                        <li
                                            class="px-4 py-2 text-sm text-gray-600 hover:bg-blue-100 cursor-pointer transition-colors duration-200 ease-in-out"
                                            role="option"
                                            x-on:click="setSelectedOption(item)"
                                            tabindex="0"
                                        >
                                            <span x-bind:class="selectedOption == item ? 'font-bold' : null" x-text="item.label"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                        <!-- Error Message -->
                        @error('employee_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Bonus Name -->
                    <div>
                        <label for="bonus_name" class="block text-lg font-semibold mb-2">Incentive Name</label>
                        <input type="text" wire:model="bonus_name" id="bonus_name" class="outline-none border transition-all duration-200 ease-in-out border-gray-300 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300">
                        @error('bonus_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-lg font-semibold mb-2">Amount</label>
                        <input type="number" wire:model="amount" id="amount" class="outline-none border transition-all duration-200 ease-in-out border-gray-300 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300" step="1">
                        @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div x-data="{ bonus_type: '', showFrequency: false }" class="space-y-4">
                        <!-- Bonus Type -->
                        <div>
                            <label for="bonus_type" class="block text-lg font-semibold mb-2">Bonus Type</label>
                            <select wire:model="bonus_type" x-model="bonus_type" @change="showFrequency = bonus_type === 'recurring'" id="bonus_type" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300">
                                <option value="one_time">One-Time</option>
                                <option value="recurring">Recurring</option>
                                <option value="recurring_indefinitely">Recurring Indefinitely</option>
                            </select>
                            @error('bonus_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Frequency -->
                        <div x-show="showFrequency">
                            <label for="frequency" class="block text-lg font-semibold mb-2">Frequency</label>
                            <input wire:model="frequency" type="number" id="frequency" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300" min="1">
                        </div>
                        @error('frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <!-- Modal Actions -->
                    <div class="flex justify-between mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                            Add Bonus
                        </button>
                        <button wire:click="closeModal" type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-lg transition transform hover:scale-105">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
