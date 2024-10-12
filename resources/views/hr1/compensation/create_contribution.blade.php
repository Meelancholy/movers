<!-- resources/views/hr1/compensation/create_contribution.blade.php -->
@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-xl font-bold">Add Contribution</h1>

    <form action="{{ route('compensation.store_contribution') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="employee_id" class="block">Employee:</label>
            <select name="employee_id" id="employee_id" class="form-select">
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block">Contributions:</label>
            <div>
                <input type="checkbox" name="philhealth" id="philhealth" value="1"> Philhealth
            </div>
            <div>
                <input type="checkbox" name="sss" id="sss" value="1"> SSS
            </div>
            <div>
                <input type="checkbox" name="pagibig" id="pagibig" value="1"> Pagibig
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Contribution</button>
    </form>
</div>
@endsection
