@extends('hr1.layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold">Add New Department</h1>
    <form action="{{ route('department.store') }}" method="POST">
        @csrf
        <div>
            <label for="name" class="block">Department Name</label>
            <input type="text" name="name" id="name" required class="border rounded p-2 w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Add Department</button>
    </form>
</div>
@endsection
