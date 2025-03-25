<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function list()
    {
        return view('hr1.employee_management.employee_list');
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('hr1.employee_management.employee_edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'status' => 'required|string',
            'contact' => 'required|string|min:11|max:11',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return redirect()->route('employee.list')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.list')->with('success', 'Employee deleted successfully.');
    }
}
