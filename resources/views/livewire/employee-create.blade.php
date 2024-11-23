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
                <h3 id="defaultModalTitle" class="font-semibold tracking-wide text-gray-900">CREATE EMPLOYEE</h3>
                <button @click="modalIsOpen = false" aria-label="close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div
            x-data="{
                allDepartments: {{ Js::from($departments->map(fn($d) => ['label' => $d->name, 'value' => $d->id])) }},
                allPositions: {{ Js::from($positions->map(fn($p) => ['label' => $p->name, 'value' => $p->id, 'department_id' => $p->department_id])) }},
                departmentOptions: [],
                positionOptions: [],
                selectedDepartment: @entangle('department_id'),
                selectedPosition: @entangle('position_id'),
                isDepartmentOpen: false,
                isPositionOpen: false,

                setDepartment(option) {
                    this.selectedDepartment = option.value;
                    this.selectedPosition = null; // Reset position when department changes
                    this.filterPositions();
                    this.isDepartmentOpen = false;
                },

                setPosition(option) {
                    this.selectedPosition = option.value;
                    this.isPositionOpen = false;
                },

                filterPositions() {
                    if (this.selectedDepartment) {
                        this.positionOptions = this.allPositions.filter(position => position.department_id === this.selectedDepartment);
                    } else {
                        this.positionOptions = [];
                    }
                },

                getFilteredOptions(query, options) {
                    return options.filter(option =>
                        option.label.toLowerCase().includes(query.toLowerCase())
                    );
                },

                init() {
                    this.departmentOptions = this.allDepartments;
                    this.positionOptions = this.allPositions;
                }
            }"
            x-init="init()"
            class="px-4 pt-4"
        >
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
        <!-- Department Dropdown -->
        <div class="relative">
            <label for="department" class="w-fit pl-0.5 text-sm">Department</label>
            <button
                type="button"
                class="form-input inline-flex w-full items-center justify-between gap-2 rounded-lg bg-neutral-100 px-4 py-2 text-sm text-neutral-600"
                x-on:click="isDepartmentOpen = !isDepartmentOpen"
                x-bind:aria-expanded="isDepartmentOpen"
                x-bind:aria-label="selectedDepartment ? allDepartments.find(department => department.value === selectedDepartment).label : 'Please Select Department'"
            >
                <span x-text="selectedDepartment ? allDepartments.find(department => department.value === selectedDepartment).label : 'Please Select Department'"></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-600"
                    x-bind:class="{'rotate-180': isDepartmentOpen, 'transition-transform': true}"
                    style="transition: transform 0.2s ease-in-out;">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div
                x-show="isDepartmentOpen"
                x-on:click.outside="isDepartmentOpen = false"
                class="absolute mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-auto"
                x-transition
            >
                <input
                    type="text"
                    x-ref="searchFieldDepartment"
                    class="w-full p-2 border-b border-gray-300"
                    placeholder="Search department"
                    x-on:input="departmentOptions = getFilteredOptions($el.value, allDepartments)"
                />
                <ul>
                    <template x-for="department in departmentOptions" :key="department.value">
                        <li @click="setDepartment(department)" class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                            <span x-text="department.label"></span>
                        </li>
                    </template>
                </ul>
            </div>
            @error('department_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Position Dropdown -->
        <div class="relative">
            <label for="position" class="w-fit pl-0.5 text-sm">Position</label>
            <button
                type="button"
                class="form-input inline-flex w-full items-center justify-between gap-2 rounded-lg bg-neutral-100 px-4 py-2 text-sm text-neutral-600"
                x-on:click="isPositionOpen = !isPositionOpen"
                x-bind:aria-expanded="isPositionOpen"
                x-bind:aria-label="selectedPosition ? allPositions.find(position => position.value === selectedPosition).label : 'Please Select Position'"
                x-bind:disabled="positionOptions.length === 0"
            >
                <span x-text="selectedPosition ? allPositions.find(position => position.value === selectedPosition).label : (positionOptions.length === 0 ? 'No positions available' : 'Please Select Position')"></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-600"
                    x-bind:class="{'rotate-180': isPositionOpen, 'transition-transform': true}"
                    style="transition: transform 0.2s ease-in-out;">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div
                x-show="isPositionOpen"
                x-on:click.outside="isPositionOpen = false"
                class="absolute mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-auto"
                x-transition
            >
                <input
                    type="text"
                    x-ref="searchFieldPosition"
                    class="w-full p-2 border-b border-gray-300"
                    placeholder="Search position"
                    x-on:input="positionOptions = getFilteredOptions($el.value, allPositions)"
                />
                <ul>
                    <template x-for="position in positionOptions" :key="position.value">
                        <li @click="setPosition(position)" class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                            <span x-text="position.label"></span>
                        </li>
                    </template>
                </ul>
            </div>
            @error('position_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
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
                            <input type="number" wire:model.defer="contact" id="contact" class="w-full bg-neutral-100 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 rounded-lg" name="contact" placeholder="Enter your contact number" autocomplete="contact"/>
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
                            Create Employee
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
