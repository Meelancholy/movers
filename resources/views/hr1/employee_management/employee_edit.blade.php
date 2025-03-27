@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-6 bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6">Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <!-- Edit Employee Form -->
    <form method="POST" action="{{ route('employee.update', $employee->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-lg font-semibold mb-2">First Name</label>
                <input type="text" name="first_name" id="first_name"
                       class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                       value="{{ old('first_name', $employee->first_name) }}" required>
                @error('first_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-lg font-semibold mb-2">Last Name</label>
                <input type="text" name="last_name" id="last_name"
                       class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                       value="{{ old('last_name', $employee->last_name) }}" required>
                @error('last_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-lg font-semibold mb-2">Status</label>
                <select name="status" id="status"
                        class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300" required>
                    <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="on leave" {{ old('status', $employee->status) == 'on leave' ? 'selected' : '' }}>On Leave</option>
                    <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contact -->
            <div>
                <label for="contact" class="block text-lg font-semibold mb-2">Contact Number</label>
                <input type="text" name="contact" id="contact"
                       class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                       value="{{ old('contact', $employee->contact) }}" required minlength="11" maxlength="11">
                @error('contact')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Adjustments Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Employee Adjustments</h2>
            <p class="text-sm text-gray-500 mb-4">Use negative values for Permanent frequency</p>

            <div id="adjustments-container">
                @foreach(old('adjustments', $employee->adjustments) as $index => $adjustment)
                <div class="adjustment-item mb-4 p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="adjustment_id_{{ $index }}" class="block text-sm font-semibold mb-1">Adjustment</label>
                            <select name="adjustments[{{ $index }}][adjustment_id]" id="adjustment_id_{{ $index }}"
                                    class="border border-gray-300 rounded-full px-4 py-2 w-full" required>
                                @foreach($allAdjustments as $adj)
                                    <option value="{{ $adj->id }}"
                                        {{ (is_object($adjustment) && $adj->id == $adjustment->id) ||
                                           (is_array($adjustment) && $adj->id == $adjustment['adjustment_id']) ? 'selected' : '' }}>
                                        {{ $adj->adjustment }}
                                        @if($adj->fixedamount)
                                            (₱{{ number_format($adj->fixedamount, 2) }})
                                        @elseif($adj->percentage)
                                            ({{ $adj->percentage }}%)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="frequency_{{ $index }}" class="block text-sm font-semibold mb-1">Frequency</label>
                            <input type="number" name="adjustments[{{ $index }}][frequency]" id="frequency_{{ $index }}"
                                   class="border border-gray-300 rounded-full px-4 py-2 w-full frequency-input"
                                   value="{{ is_object($adjustment) ? $adjustment->pivot->frequency : ($adjustment['frequency'] ?? 1) }}"
                                   min="-12" max="12" step="1" required>
                        </div>
                    </div>
                    <button type="button" class="mt-2 text-red-500 text-sm remove-adjustment">Remove</button>
                </div>
                @endforeach
            </div>

            <button type="button" id="add-adjustment" class="mt-4 bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm">
                + Add Adjustment
            </button>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Update Employee
            </button>
            <a href="{{ route('employee.list') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-full transition transform hover:scale-105">
                Back to List
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('adjustments-container');
        const addButton = document.getElementById('add-adjustment');
        let index = {{ count(old('adjustments', $employee->adjustments)) }};

        // Add new adjustment
        addButton.addEventListener('click', function() {
            const template = `
                <div class="adjustment-item mb-4 p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="adjustment_id_${index}" class="block text-sm font-semibold mb-1">Adjustment</label>
                            <select name="adjustments[${index}][adjustment_id]" id="adjustment_id_${index}"
                                    class="border border-gray-300 rounded-full px-4 py-2 w-full" required>
                                @foreach($allAdjustments as $adj)
                                    <option value="{{ $adj->id }}">
                                        {{ $adj->adjustment }}
                                        @if($adj->fixedamount)
                                            (₱{{ number_format($adj->fixedamount, 2) }})
                                        @elseif($adj->percentage)
                                            ({{ $adj->percentage }}%)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="frequency_${index}" class="block text-sm font-semibold mb-1">Frequency</label>
                            <input type="number" name="adjustments[${index}][frequency]" id="frequency_${index}"
                                   class="border border-gray-300 rounded-full px-4 py-2 w-full frequency-input"
                                   value="1" min="-12" max="12" step="1" required>
                        </div>
                    </div>
                    <button type="button" class="mt-2 text-red-500 text-sm remove-adjustment">Remove</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', template);
            index++;
        });

        // Remove adjustment
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-adjustment')) {
                e.target.closest('.adjustment-item').remove();
            }
        });

        // Highlight negative frequencies
        function highlightNegativeFrequencies() {
            document.querySelectorAll('.frequency-input').forEach(input => {
                const parentDiv = input.closest('div');
                if (parseInt(input.value) < 0) {
                    parentDiv.classList.add('text-green-500');
                    parentDiv.classList.remove('text-green-500');
                } else {
                    parentDiv.classList.add('text-green-500');
                    parentDiv.classList.remove('text-green-500');
                }
            });
        }

        // Initial highlight
        highlightNegativeFrequencies();

        // Highlight on change
        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('frequency-input')) {
                highlightNegativeFrequencies();
            }
        });
    });
</script>

<style>
    .text-red-500 input {
        color: #ef4444;
    }
    .text-green-500 input {
        color: #10b981;
    }
</style>
@endsection
