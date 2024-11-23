<div class="" x-data="{ modalIsOpen: false }">
    <!-- Open Modal Button -->
    <button
        @click="modalIsOpen = true"
        type="button"
        class="flex items-center justify-center bg-blue-500 w-full hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center"
    >
        Create Employee
    </button>

    <!-- Modal Overlay -->
    <div
        x-cloak
        x-show="modalIsOpen"
        x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="modalIsOpen"
        @keydown.esc.window="modalIsOpen = false"
        @click.self="modalIsOpen = false"
        class="fixed inset-0 z-30 flex items-end justify-center bg-gray-800/70 p-6 pb-8 backdrop-blur-sm sm:items-center lg:p-8"
        role="dialog"
        aria-modal="true"
        aria-labelledby="defaultModalTitle"
    >
        <!-- Modal Dialog -->
        <div
            x-show="modalIsOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="scale-0"
            x-transition:enter-end="scale-100"
            class="flex max-w-lg flex-col overflow-hidden rounded-lg bg-white text-gray-700"
        >
            <!-- Dialog Header -->
            <div class="flex items-center justify-between bg-gray-100/80 p-4">
                <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-gray-900">ADD EMPLOYEE</h3>
                <button @click="modalIsOpen = false" aria-label="close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Dialog Body -->
            <div class="px-4 pt-4">
                <form wire:submit.prevent="submitForm" class="space-y-6">

                    <!-- Grid Layout for Inputs -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <!-- First Name -->
                        <div class="flex w-full max-w-xs flex-col gap-1 text-neutral-600">
                            <label for="textInputDefault" class="w-fit pl-0.5 text-sm">First Name</label>
                            <input type="text" wire:model.defer="first_name" id="first_name" class="w-full bg-neutral-100 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 rounded-lg" name="fname" placeholder="Enter your first name" autocomplete="fname"/>
                            @error('first_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="flex w-full max-w-xs flex-col gap-1 text-neutral-600">
                            <label for="textInputDefault" class="w-fit pl-0.5 text-sm">Last Name</label>
                            <input type="text" wire:model.defer="last_name" id="last_name" class="w-full bg-neutral-100 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 rounded-lg" name="lname" placeholder="Enter your last name" autocomplete="lname"/>
                            @error('last_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Department -->
                        <div
                        x-data="{
                                allOptions: {{ Js::from($departments->map(fn($d) => ['label' => $d->name, 'value' => $d->id])) }},
                                options: [],
                                isOpen: false,
                                openedWithKeyboard: false,
                                selectedOption: null,
                                setSelectedOption(option) {
                                    this.selectedOption = option;
                                    this.isOpen = false;
                                    this.openedWithKeyboard = false;
                                    this.$refs.hiddenTextField.value = option.value;
                                    $wire.set('department_id', option.value); // Connect to Livewire model
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
                            class="relative"
                            x-init="options = allOptions"
                            >
                                <!-- Label -->
                                <label for="department" class="w-fit pl-0.5 text-sm">Department</label>

                                <!-- Input Button -->
                                <button
                                    type="button"
                                    class="form-input inline-flex w-full items-center justify-between gap-2 rounded-lg bg-neutral-100 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black"
                                    role="combobox"
                                    aria-controls="departmentList"
                                    aria-haspopup="listbox"
                                    x-on:click="isOpen = !isOpen"
                                    x-bind:aria-expanded="isOpen || openedWithKeyboard"
                                    x-bind:aria-label="selectedOption ? selectedOption.label : 'Please Select Department'"
                                >
                                    <!-- Placeholder or Selected Option -->
                                    <span x-text="selectedOption ? selectedOption.label : 'Please Select Department'" class="text-sm font-normal text-gray-600"></span>

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
                                <input type="hidden" x-ref="hiddenTextField" id="department" wire:model="department_id">

                                <!-- Dropdown -->
                                <div
                                    x-show="isOpen || openedWithKeyboard"
                                    id="departmentList"
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
                                    <ul class="flex flex-col">
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
                            @error('department_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Position -->
                        <div
                        x-data="{
                                allOptions: {{ Js::from($positions->map(fn($d) => ['label' => $d->name, 'value' => $d->id])) }},
                                options: [],
                                isOpen: false,
                                openedWithKeyboard: false,
                                selectedOption: null,
                                setSelectedOption(option) {
                                    this.selectedOption = option;
                                    this.isOpen = false;
                                    this.openedWithKeyboard = false;
                                    this.$refs.hiddenTextField.value = option.value;
                                    $wire.set('position_id', option.value); // Connect to Livewire model
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
                            class="relative"
                            x-init="options = allOptions"
                            >
                                <!-- Label -->
                                <label for="position" class="w-fit pl-0.5 text-sm">Position</label>

                                <!-- Input Button -->
                                <button
                                    type="button"
                                    class="form-input inline-flex w-full items-center justify-between gap-2 rounded-lg bg-neutral-100 px-4 py-2 text-sm font-medium tracking-wide text-neutral-600 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black"
                                    role="combobox"
                                    aria-controls="positionList"
                                    aria-haspopup="listbox"
                                    x-on:click="isOpen = !isOpen"
                                    x-bind:aria-expanded="isOpen || openedWithKeyboard"
                                    x-bind:aria-label="selectedOption ? selectedOption.label : 'Please Select Position'"
                                >
                                    <!-- Placeholder or Selected Option -->
                                    <span x-text="selectedOption ? selectedOption.label : 'Please Select Position'" class="text-sm font-normal text-gray-600"></span>

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
                                <input type="hidden" x-ref="hiddenTextField" id="position" wire:model="position_id">

                                <!-- Dropdown -->
                                <div
                                    x-show="isOpen || openedWithKeyboard"
                                    id="positionList"
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
                                    <ul class="flex flex-col">
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
                            @error('position_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="flex w-full max-w-xs flex-col gap-1 text-neutral-600">
                            <label for="textInputDefault" class="w-fit pl-0.5 text-sm">Email</label>
                            <input type="text" wire:model.defer="email" id="email" class="w-full bg-neutral-100 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 rounded-lg" name="lname" placeholder="Enter your email" autocomplete="lname"/>
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Contact -->
                        <div class="flex w-full max-w-xs flex-col gap-1 text-neutral-600">
                            <label for="textInputDefault" class="w-fit pl-0.5 text-sm">Contact</label>
                            <input type="text" wire:model.defer="contact" id="contact" class="w-full bg-neutral-100 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 rounded-lg" name="contact" placeholder="Enter your contact number" autocomplete="contact"/>
                            @error('contact')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Submit Button (Add Department) -->
                    <div class="mt-6">
                        <button
                            type="submit"
                            class="rounded-lg cursor-pointer whitespace-nowrap bg-blue-600 px-4 py-2 text-center text-sm font-medium tracking-wide text-white transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 active:opacity-100 active:outline-offset-0 w-full"
                        >
                            Add Department
                        </button>
                    </div>
                </form>
            </div>

            <!-- Remind me later button -->
            <button
                @click="modalIsOpen = false"
                type="button"
                class="cursor-pointer whitespace-nowrap p-3 text-center text-sm font-medium tracking-wide text-gray-700 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 active:opacity-100 active:outline-offset-0"
            >
                Back to Department List
            </button>
        </div>
    </div>
</div>
