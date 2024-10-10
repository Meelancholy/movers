@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add New Position</h1>
    <form action="{{ route('position.store') }}" method="POST">
        @csrf
        <div>
            <label for="title" class="block">Position Title</label>
            <input type="text" name="title" id="title" required class="border rounded p-2 w-full">
        </div>
        <div>
            <label for="base_salary" class="block">Base Salary</label>
            <input type="number" name="base_salary" id="base_salary" required class="border rounded p-2 w-full">
        </div>
        <div>
            <label for="department_id" class="block">Department</label>
            <select name="department_id" id="department_id" required class="border rounded p-2 w-full">
                <option value="">Select a Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Add Position</button>
    </form>
</div>
@endsection
