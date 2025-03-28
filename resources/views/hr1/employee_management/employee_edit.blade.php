@extends('hr1.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold bg-white rounded-lg shadow-md mx-auto mt-6 p-8 mb-6">{{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <!-- Edit Employee Form -->
    <form method="POST" action="{{ route('employee.update', $employee->id) }}" class="space-y-6 bg-white rounded-lg shadow-md mx-auto p-8 " id="employee-form">
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
            <!-- Email -->
            <div>
                <label for="email" class="block text-lg font-semibold mb-2">Email</label>
                <input type="text" name="email" id="email"
                       class="border border-gray-300 rounded-full px-4 py-2 w-full focus:ring focus:ring-blue-300"
                       value="{{ old('first_name', $employee->email) }}" required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        @php
            // Get hours worked from attendance (sum all hours for this employee)
            $hours = $employee->attendances->sum('hours_worked');
            // Get hourly rate from employee's salary
            $rate = $employee->salary->hourly_rate ?? 0;
            $baseSalary = $hours * $rate;
        @endphp

        <!-- Adjustments Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Employee Adjustments</h2>
            <p class="text-sm text-gray-500 mb-4">Use -1 for Permanent frequency (will apply every payroll)</p>

            <div id="adjustments-container">
                @foreach(old('adjustments', $employee->adjustments) as $index => $adjustment)
                <div class="adjustment-item mb-4 p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="adjustment_id_{{ $index }}" class="block text-sm font-semibold mb-1">Adjustment</label>
                            <select name="adjustments[{{ $index }}][adjustment_id]" id="adjustment_id_{{ $index }}"
                                    class="border border-gray-300 rounded-full px-4 py-2 w-full adjustment-select" required>
                                @foreach($allAdjustments as $adj)
                                    @php
                                        // Check if base salary falls within the adjustment's range
                                        $showAdjustment = true;
                                        if ($adj->rangestart !== null && $baseSalary < $adj->rangestart) {
                                            $showAdjustment = false;
                                        }
                                        if ($adj->rangeend !== null && $baseSalary > $adj->rangeend) {
                                            $showAdjustment = false;
                                        }
                                    @endphp
                                    @if($showAdjustment || (is_object($adjustment) && $adj->id == $adjustment->id) || (is_array($adjustment) && $adj->id == $adjustment['adjustment_id']))
                                        <option value="{{ $adj->id }}"
                                            data-type="{{ $adj->fixedamount ? 'fixed' : 'percentage' }}"
                                            data-value="{{ $adj->fixedamount ?? $adj->percentage }}"
                                            {{ (is_object($adjustment) && $adj->id == $adjustment->id) ||
                                               (is_array($adjustment) && $adj->id == $adjustment['adjustment_id']) ? 'selected' : '' }}>
                                            {{ $adj->adjustment }}
                                            @if($adj->fixedamount)
                                                (₱{{ number_format($adj->fixedamount, 2) }})
                                            @elseif($adj->percentage)
                                                ({{ $adj->percentage }}%)
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="frequency_{{ $index }}" class="block text-sm font-semibold mb-1">Frequency</label>
                            <input type="number" name="adjustments[{{ $index }}][frequency]" id="frequency_{{ $index }}"
                                   class="border border-gray-300 rounded-full px-4 py-2 w-full frequency-input"
                                   value="{{ is_object($adjustment) ? $adjustment->pivot->frequency : ($adjustment['frequency'] ?? 1) }}"
                                   min="-1" step="1" required oninput="validateFrequency(this)">
                            <span class="text-red-500 text-sm hidden frequency-error">Frequency cannot be 0</span>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Amount</label>
                            <div class="border border-gray-300 rounded-full px-4 py-2 w-full adjustment-amount">
                                @php
                                    $adj = is_object($adjustment) ? $adjustment : $allAdjustments->firstWhere('id', $adjustment['adjustment_id']);
                                    $amount = 0;
                                    if ($adj->fixedamount) {
                                        $amount = $adj->fixedamount;
                                    } elseif ($adj->percentage) {
                                        $amount = $baseSalary * $adj->percentage / 100;
                                    }
                                    echo '₱' . number_format($amount, 2);
                                @endphp
                            </div>
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
        const form = document.getElementById('employee-form');
        let index = {{ count(old('adjustments', $employee->adjustments)) }};

        // Get base salary from database values
        const baseSalary = {{ ($employee->attendances->sum('hours_worked')) * ($employee->salary->hourly_rate ?? 0) }};

        // Add new adjustment
        addButton.addEventListener('click', function() {
            const template = `
                <div class="adjustment-item mb-4 p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="adjustment_id_${index}" class="block text-sm font-semibold mb-1">Adjustment</label>
                            <select name="adjustments[${index}][adjustment_id]" id="adjustment_id_${index}"
                                    class="border border-gray-300 rounded-full px-4 py-2 w-full adjustment-select" required>
                                @foreach($allAdjustments as $adj)
                                    @php
                                        // Check if base salary falls within the adjustment's range
                                        $showAdjustment = true;
                                        if ($adj->rangestart !== null && $baseSalary < $adj->rangestart) {
                                            $showAdjustment = false;
                                        }
                                        if ($adj->rangeend !== null && $baseSalary > $adj->rangeend) {
                                            $showAdjustment = false;
                                        }
                                    @endphp
                                    @if($showAdjustment)
                                        <option value="{{ $adj->id }}"
                                            data-type="{{ $adj->fixedamount ? 'fixed' : 'percentage' }}"
                                            data-value="{{ $adj->fixedamount ?? $adj->percentage }}">
                                            {{ $adj->adjustment }}
                                            @if($adj->fixedamount)
                                                (₱{{ number_format($adj->fixedamount, 2) }})
                                            @elseif($adj->percentage)
                                                ({{ $adj->percentage }}%)
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="frequency_${index}" class="block text-sm font-semibold mb-1">Frequency</label>
                            <input type="number" name="adjustments[${index}][frequency]" id="frequency_${index}"
                                   class="border border-gray-300 rounded-full px-4 py-2 w-full frequency-input"
                                   value="1" min="-1" step="1" required oninput="validateFrequency(this)">
                            <span class="text-red-500 text-sm hidden frequency-error">Frequency cannot be 0</span>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Amount</label>
                            <div class="border border-gray-300 rounded-full px-4 py-2 w-full adjustment-amount">
                                ₱0.00
                            </div>
                        </div>
                    </div>
                    <button type="button" class="mt-2 text-red-500 text-sm remove-adjustment">Remove</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', template);
            index++;
            calculateAmounts();
        });

        // Remove adjustment
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-adjustment')) {
                e.target.closest('.adjustment-item').remove();
            }
        });

        // Validate frequency input to prevent 0
        function validateFrequency(input) {
            const errorSpan = input.nextElementSibling;
            if (input.value == 0) {
                errorSpan.classList.remove('hidden');
                input.value = input.value > 0 ? 1 : -1; // Set to 1 if positive, -1 if negative
            } else {
                errorSpan.classList.add('hidden');
            }
        }

        // Calculate adjustment amounts (without frequency multiplication)
        function calculateAmounts() {
            const adjustmentItems = document.querySelectorAll('.adjustment-item');

            adjustmentItems.forEach(item => {
                const select = item.querySelector('.adjustment-select');
                const amountDisplay = item.querySelector('.adjustment-amount');

                const type = select.options[select.selectedIndex].dataset.type;
                const value = parseFloat(select.options[select.selectedIndex].dataset.value) || 0;

                let amount = 0;

                if (type === 'fixed') {
                    amount = value;
                } else if (type === 'percentage') {
                    amount = baseSalary * (value / 100);
                }

                amountDisplay.textContent = `₱${amount.toFixed(2)}`;
            });
        }

        // Event listeners for calculation
        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('adjustment-select')) {
                calculateAmounts();
            }
        });

        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('frequency-input')) {
                validateFrequency(e.target);
            }
        });

        // Initialize validation on existing inputs
        document.querySelectorAll('.frequency-input').forEach(input => {
            validateFrequency(input);
        });
    });
</script>
@endsection
