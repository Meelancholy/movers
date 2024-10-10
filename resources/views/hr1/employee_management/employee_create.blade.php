@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add New Employee</h1>

    <form method="POST" action="{{ route('employee.store') }}">
        @csrf
        <div>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-input" required>
        </div>
        <div>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-input" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" class="form-input" required>
        </div>
        <div>
            <label for="department_id">Department</label>
            <select name="department_id" class="form-select" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="position_id">Position</label>
            <select name="position_id" class="form-select" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status">Status</label>
            <select name="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="on leave">On Leave</option>
                <option value="terminated">Terminated</option>
            </select>
        </div>
        <div>
            <label for="contact">Contact</label>
            <input type="text" name="contact" class="form-input" placeholder="Optional">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Employee</button>
    </form>
</div>
@endsection
