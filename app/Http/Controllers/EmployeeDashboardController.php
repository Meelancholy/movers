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
        $departments = Department::with(['positions', 'employees'])->get();

        // Fetch positions with employee count
        $totalPositions = Position::count();
        $positions = Position::withCount('employees')->get();

        // Pass the data to the view
        return view('hr1.employee_management.employee_dashboard', compact('totalEmployees', 'activeEmployees', 'inactiveEmployees', 'departments', 'positions','totalPositions','totalDepartments'));
    }




    // Display Employee Profile/Management
    public function profile($id)
    {
        // Retrieve the employee with its department and position relationships
        $employee = Employee::with(['department', 'position'])->findOrFail($id);

        // Retrieve all departments and positions
        $departments = Department::all();
        $positions = Position::all();

        // Pass the data to the view
        return view('hr1.employee_management.employee_profile', compact('employee', 'departments', 'positions'));
    }


    // Add methods for storing, editing, and deleting employees
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('hr1.employee_management.employee_create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'status' => 'required|string',
            'contact' => 'nullable|string|max:255', // Ensure this is validated
        ]);

        // Create the employee with all input data including contact
        $employee = Employee::create($request->all());

        return redirect()->route('employee.list')->with('success', 'Employee created successfully.');
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
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'status' => 'required|string',
            'contact' => 'nullable|string|max:255',
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
