<div>
    <!-- Trigger Button (You can place this anywhere you need to open the modal) -->
    <button wire:click="openModal" class="bg-blue-500 w-full hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition transform hover:scale-105 shadow-lg text-center">
        Add Position
    </button>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-96">
                <h1 class="text-2xl font-bold mb-6">Add New Position</h1>

                <form wire:submit.prevent="submit" class="space-y-6">
                    @csrf

                    <!-- Position Name -->
                    <div>
                        <label for="name" class="block text-lg font-semibold mb-2">Position Name</label>
                        <input type="text" id="name" wire:model="name" required class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Base Salary -->
                    <div>
                        <label for="base_salary" class="block text-lg font-semibold mb-2">Base Salary</label>
                        <input type="number" id="base_salary" wire:model="base_salary" required class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
                        @error('base_salary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Department Selection -->
                    <div>
                        <label for="department_id" class="block text-lg font-semibold mb-2">Department</label>
                        <select id="department_id" wire:model="department_id" required class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300">
                            <option value="">Select a Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                            Add Position
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
