<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('hr1.employee_management.employee_dashboard', compact('departments'));
    }

    public function create()
    {
        return view('hr1.employee_management.department_create'); // Create a view for adding department
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:departments']);
        Department::create($request->all());
        return redirect()->route('employee.dashboard')->with('success', 'Department created successfully.');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('hr1.employee_management.department_edit', compact('department')); // Create a view for editing department
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255|unique:departments,name,'.$id]);
        $department = Department::findOrFail($id);
        $department->update($request->all());
        return redirect()->route('employee.dashboard')->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('employee.dashboard')->with('success', 'Department deleted successfully.');
    }
}
