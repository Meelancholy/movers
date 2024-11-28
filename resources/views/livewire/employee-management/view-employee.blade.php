<!-- Modal -->
<div x-show="viewmodalIsOpen" x-cloak x-transition.opacity.duration.200ms x-trap.inert.noscroll="viewmodalIsOpen" @keydown.esc.window="viewmodalIsOpen = false" @click.self="viewmodalIsOpen = false" class="fixed inset-0 z-30 flex items-end justify-center bg-gray-800/70 p-6 pb-8 backdrop-blur-sm sm:items-center lg:p-8">
    <div x-show="viewmodalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="max-w-lg w-full p-6 bg-white rounded-lg shadow-lg">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <h3 class="text-xl font-semibold">Employee Details</h3>
            <button @click="closeViewModal()" aria-label="close modal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <!-- Modal Content: Display Employee Information -->
        <div x-show="selectedEmployeeId" class="space-y-4">
            <p><strong>Employee ID:</strong> <span x-text="selectedEmployeeId"></span></p>
            <p><strong>Full Name:</strong> <span x-text="selectedEmployeeName"></span></p>
            <p><strong>Status:</strong> <span x-text="selectedEmployeeStatus"></span></p>
            <p><strong>Email:</strong> <span x-text="selectedEmployeeEmail"></span></p>
            <p><strong>Contact#:</strong> <span x-text="selectedEmployeeContact"></span></p>
            <p><strong>Department:</strong> <span x-text="selectedEmployeeDepartment"></span></p>
            <p><strong>Position:</strong> <span x-text="selectedEmployeePosition"></span></p>
            <p><strong>Hire Date:</strong> <span x-text="selectedEmployeeHireDate"></span></p>
        </div>
        <div class="mt-4 flex justify-end space-x-4">
            <button @click="closeViewModal()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-full">Close</button>
        </div>
    </div>
</div>
