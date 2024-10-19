@extends('hr1.layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10 container min-w-full">

    <!-- Payroll Details Section -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Payroll Details for {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</h1>

    <div class="mb-8">
        <h2 class="text-lg font-medium text-gray-700 mb-2">Employee ID: {{ $payroll->employee->id }}</h2>
        <h2 class="text-lg font-medium text-gray-700 mb-2">Salary: ₱{{ number_format($payroll->salary, 2) }}</h2>
        <h2 class="text-lg font-medium text-gray-700 mb-2">Gross Salary: ₱{{ number_format($payroll->gross_salary, 2) }}</h2>
        <h2 class="text-lg font-medium text-gray-700 mb-2">Withholdings: ₱{{ number_format($payroll->withholdings, 2) }}</h2>
        <h2 class="text-lg font-medium text-gray-700 mb-2">Net Salary: ₱{{ number_format($payroll->net_salary, 2) }}</h2>
        <h2 class="text-lg font-medium text-gray-700 mb-2">Generated On: {{ $payroll->created_at->format('Y-m-d H:i:s') }}</h2>
    </div>

    <!-- Bonus Histories Section -->
    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-800">Bonus Histories</h3>
        @if($payroll->bonusHistories->isNotEmpty())
            <ul class="list-disc ml-6">
                @foreach($payroll->bonusHistories as $bonus)
                    <li>
                        <strong>Description:</strong> {{ $bonus->description }}<br>
                        <strong>Amount:</strong> ₱{{ number_format($bonus->amount, 2) }}<br>
                        <strong>Date Added:</strong> {{ $bonus->created_at->format('Y-m-d H:i:s') }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-700">No bonuses added for this payroll.</p>
        @endif
    </div>

    <!-- Deduction Histories Section -->
    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-800">Deduction Histories</h3>
        @if($payroll->deductionHistories->isNotEmpty())
            <ul class="list-disc ml-6">
                @foreach($payroll->deductionHistories as $deduction)
                    <li>
                        <strong>Description:</strong> {{ $deduction->description }}<br>
                        <strong>Amount:</strong> ₱{{ number_format($deduction->amount, 2) }}<br>
                        <strong>Date Added:</strong> {{ $deduction->created_at->format('Y-m-d H:i:s') }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-700">No deductions applied for this payroll.</p>
        @endif
    </div>

    <!-- Back to Records Button at the Bottom -->
    <div class="mt-8">
        <a href="{{ route('payroll.records') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
            Back to Records
        </a>
    </div>
</div>
@endsection
