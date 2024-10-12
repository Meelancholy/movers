@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-4xl font-bold text-blue-900 mb-8">Add Deduction</h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('compensation.store_deduction') }}" method="POST" class="bg-white shadow-xl rounded-lg p-8 space-y-6" onsubmit="return validateForm()">
        @csrf

        <div class="mb-6">
            <label for="employee_id" class="block text-gray-700 font-semibold mb-2">Employee:</label>
            <div class="relative">
                <input type="text" id="search" placeholder="Search by Name or ID" class="form-input border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out" onkeyup="filterEmployees()" autocomplete="off" required>
                <ul id="employee-list" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-40 overflow-auto shadow-lg hidden opacity-0 transition-opacity duration-300 ease-in-out">
                    @if($employees->isEmpty())
                        <li class="px-4 py-2 text-gray-500">No employees found</li>
                    @else
                        @foreach($employees as $employee)
                            <li class="employee-option px-4 py-2 hover:bg-blue-100 cursor-pointer transition-colors duration-200 ease-in-out" data-id="{{ $employee->id }}">
                                {{ $employee->first_name }} {{ $employee->last_name }} (ID: {{ $employee->id }})
                            </li>
                        @endforeach
                    @endif
                </ul>
                <input type="hidden" name="employee_id" id="employee_id" required>
            </div>
        </div>

        <div class="mb-6">
            <label for="deduction_name" class="block text-gray-700 font-semibold mb-2">Deduction Name:</label>
            <input type="text" name="deduction_name" id="deduction_name" class="form-input border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out" required>
        </div>

        <div class="mb-6">
            <label for="amount" class="block text-gray-700 font-semibold mb-2">Amount:</label>
            <input type="number" name="amount" id="amount" class="form-input border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out" step="0.01" required>

            <div class="mt-4 space-x-2">
                <button type="button" class="suggest-button bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-200 ease-in-out" onclick="fillAmount(300)">₱300</button>
                <button type="button" class="suggest-button bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-200 ease-in-out" onclick="fillAmount(500)">₱500</button>
                <button type="button" class="suggest-button bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-200 ease-in-out" onclick="fillAmount(1000)">₱1,000</button>
                <button type="button" class="suggest-button bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-200 ease-in-out" onclick="fillAmount(2000)">₱2,000</button>
                <button type="button" class="suggest-button bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-200 ease-in-out" onclick="fillAmount(5000)">₱5,000</button>
                <button type="button" class="suggest-button bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 hover:scale-105 transition duration-200 ease-in-out" onclick="fillAmount(10000)">₱10,000</button>
            </div>
        </div>

        <div class="mb-6">
            <label for="deduction_type" class="block text-gray-700 font-semibold mb-2">Deduction Type:</label>
            <select name="deduction_type" id="deduction_type" class="form-select border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out" onchange="toggleFrequency()" required>
                <option value="one_time">One Time</option>
                <option value="recurring">Recurring</option>
                <option value="recurring_indefinitely">Recurring Indefinitely</option>
            </select>
        </div>

        <!-- Frequency input field (initially hidden) -->
        <div id="frequency-container" class="mb-6 hidden">
            <label for="frequency" class="block text-gray-700 font-semibold mb-2">Frequency:</label>
            <input type="number" name="frequency" id="frequency" class="form-input border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out" min="1">
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 hover:scale-105 transition duration-200 ease-in-out">Add Deduction</button>
            <a href="{{ route('compensation.index') }}" class="inline-block bg-gray-500 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-gray-600 hover:scale-105 transition duration-200 ease-in-out">
                Return to Compensation
            </a>
        </div>
    </form>
</div>

<script>
    function filterEmployees() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const employeeList = document.getElementById('employee-list');
        const options = employeeList.getElementsByClassName('employee-option');
        let hasResults = false;

        // Show the dropdown if there's text in the search bar
        if (searchInput === '') {
            employeeList.classList.add('hidden');
            employeeList.classList.remove('opacity-100');
        } else {
            employeeList.classList.remove('hidden');
            employeeList.classList.add('opacity-100');
        }

        for (let option of options) {
            const optionText = option.textContent.toLowerCase();
            const match = optionText.includes(searchInput);
            option.style.display = match ? '' : 'none';
            hasResults = hasResults || match;
        }

        // Hide the dropdown if there are no matches
        if (!hasResults) {
            employeeList.classList.add('hidden');
            employeeList.classList.remove('opacity-100');
        }
    }

    // Event listener to handle selecting an employee from the dropdown
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('employee-option')) {
            const selectedOption = event.target;
            const employeeId = selectedOption.getAttribute('data-id');
            const employeeName = selectedOption.textContent.trim(); // Trim to avoid extra spaces

            // Set the hidden input value and the search input value
            document.getElementById('employee_id').value = employeeId;
            document.getElementById('search').value = employeeName;

            // Hide the dropdown
            document.getElementById('employee-list').classList.add('hidden');
            document.getElementById('employee-list').classList.remove('opacity-100');
        }
    });

    function fillAmount(amount) {
        document.getElementById('amount').value = amount;
    }

    // Show/Hide the frequency input based on the deduction type
    function toggleFrequency() {
        const deductionType = document.getElementById('deduction_type').value;
        const frequencyContainer = document.getElementById('frequency-container');

        if (deductionType === 'recurring') {
            frequencyContainer.classList.remove('hidden');
        } else {
            frequencyContainer.classList.add('hidden');
            document.getElementById('frequency').value = ''; // Clear the frequency value if not recurring
        }
    }

    function validateForm() {
        const amount = document.getElementById('amount').value;
        const deductionType = document.getElementById('deduction_type').value;
        const frequency = document.getElementById('frequency').value;

        if (deductionType === 'recurring' && (!frequency || frequency <= 0)) {
            alert('Please enter a valid frequency for recurring deductions.');
            return false;
        }

        if (amount <= 0) {
            alert('Please enter a valid amount.');
            return false;
        }

        return true;
    }
</script>
@endsection
