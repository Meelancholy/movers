<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('hr1.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('hr1.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate(['department_name' => 'required|string|max:255']);
        Department::create($request->only('department_name'));
        return redirect()->route('departments.index');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('hr1.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['department_name' => 'required|string|max:255']);
        $department = Department::findOrFail($id);
        $department->update($request->only('department_name'));
        return redirect()->route('departments.index');
    }

    public function destroy($id)
    {
        Department::destroy($id);
        return redirect()->route('departments.index');
    }
}
