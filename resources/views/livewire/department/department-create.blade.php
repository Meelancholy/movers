<div>
    <!-- Trigger Button -->
    <button wire:click="openModal" class="bg-blue-500 hover:bg-blue-600 w-full text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
        Add New Department
    </button>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-lg w-96 p-6 shadow-lg">
                <h1 class="text-2xl font-bold mb-6">Add Department</h1>

                <!-- Department Form -->
                <form wire:submit.prevent="store" class="space-y-6">
                    @csrf
                    <!-- Department Name -->
                    <div>
                        <label for="name" class="block text-lg font-semibold mb-2">Department Name</label>
                        <input type="text" wire:model="name" id="name" class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-between mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                            Add Department
                        </button>
                        <button wire:click="closeModal" type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
