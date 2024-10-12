@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Edit Employee Compensation</h1>

    <form action="{{ route('compensation.update', $employee->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-800">{{ $employee->last_name }}, {{ $employee->first_name }}</h3>
            <p class="text-gray-600"><strong>Employee ID:</strong> {{ $employee->id }}</p>
            <p class="text-gray-600"><strong>Email:</strong> {{ $employee->email }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 mb-6">
            <h2 class="text-lg font-semibold mb-4">Social Benefits</h2>
            <div class="flex flex-col space-y-4">
                @php
                    $contributions = ['philhealth' => 'Philhealth', 'sss' => 'SSS', 'pagibig' => 'Pagibig'];
                    $contributionData = optional($employee->contributions->first());
                @endphp

                @foreach($contributions as $key => $label)
                <div class="flex items-center">
                    <input type="checkbox" name="contributions[{{ $key }}]" id="{{ $key }}" value="1"
                        {{ isset($contributionData) && $contributionData->$key ? 'checked' : '' }}>
                    <label for="{{ $key }}" class="ml-2">{{ $label }}</label>
                </div>
                @endforeach
            </div>
        </div>







        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Deductions -->
            <div class="bg-orange-100 shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-2">Deductions</h2>
                @if($employee->deductions->isEmpty())
                    <p class="text-gray-600">No deductions available.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-hidden mt-4">
                        <thead class="bg-orange-600 text-white">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium">Deduction Name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Amount</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-orange-50">
                            @foreach($employee->deductions as $deduction)
                                <tr class="hover:bg-orange-200">
                                    <td class="border px-4 py-2 text-gray-800">{{ $deduction->deduction_name }}</td>
                                    <td class="border px-4 py-2 text-orange-800">
                                        <input type="number" name="deductions[{{ $deduction->id }}][amount]" value="{{ $deduction->amount }}" required class="border rounded px-2 py-1 w-24">
                                        <input type="hidden" name="deductions[{{ $deduction->id }}][deduction_name]" value="{{ $deduction->deduction_name }}">
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button type="button" class="text-red-600 hover:underline" onclick="openModal('deduction', {{ $deduction->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Bonuses -->
            <div class="bg-blue-300 shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-2">Bonuses</h2>
                @if($employee->bonuses->isEmpty())
                    <p class="text-gray-600">No bonuses available.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-hidden mt-4">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium">Bonus Name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Amount</th>
                                <th class="px-4 py-2 text-left text-sm font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-blue-50">
                            @foreach($employee->bonuses as $bonus)
                                <tr class="hover:bg-blue-200">
                                    <td class="border px-4 py-2 text-gray-800">{{ $bonus->bonus_name }}</td>
                                    <td class="border px-4 py-2 text-blue-800">
                                        <input type="number" name="bonuses[{{ $bonus->id }}][amount]" value="{{ $bonus->amount }}" required class="border rounded px-2 py-1 w-24">
                                        <input type="hidden" name="bonuses[{{ $bonus->id }}][bonus_name]" value="{{ $bonus->bonus_name }}">
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button type="button" class="text-red-600 hover:underline" onclick="openModal('bonus', {{ $bonus->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="mt-8 flex space-x-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200">Update Compensation</button>
            <a href="{{ route('compensation.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">Cancel</a>
        </div>
    </form>
</div>
@endsection
