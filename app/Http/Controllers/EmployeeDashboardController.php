<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function list()
    {
        return view('hr1.employee_management.employee_list'); // This is your Blade view with the Livewire component
    }
    // Display Employee Dashboard
    public function index()
    {
        // Total counts for employee stats
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $inactiveEmployees = Employee::where('status', 'inactive')->count();

        // Fetch departments with employee count
        $totalDepartments = Department::count();
        $departments = Department::withCount(['positions', 'employees'])->get();

        // Fetch positions with employee count
        $totalPositions = Position::count();
        $positions = Position::withCount('employees')->get();

        // Pass the data to the view
        return view('hr1.employee_management.employee_dashboard', compact('totalEmployees', 'activeEmployees', 'inactiveEmployees', 'departments', 'positions','totalPositions','totalDepartments'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $positions = Position::all();
        return view('hr1.employee_management.employee_edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'status' => 'required|string',
            'contact' => 'nullable|string|min:11|max:11',
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
