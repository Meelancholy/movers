<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    // Display Employee Dashboard
    public function index()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $inactiveEmployees = Employee::where('status', 'inactive')->count();

        // Fetch departments with employee count
        $departments = Department::withCount('employees')->get();

        // Fetch all positions
        $positions = Position::all();

        return view('hr1.employee_management.employee_dashboard', compact('totalEmployees', 'activeEmployees', 'inactiveEmployees', 'departments', 'positions'));
    }

    // Display Employee List
    public function list(Request $request)
    {
        $employees = Employee::query();

        // Apply filters
        if ($request->filled('department_id')) {
            $employees->where('department_id', $request->department_id);
        }
        if ($request->filled('position_id')) {
            $employees->where('position_id', $request->position_id);
        }
        if ($request->filled('status')) {
            $employees->where('status', $request->status);
        }

        $employees = $employees->paginate(10);

        $departments = Department::all();
        $positions = Position::all();

        return view('hr1.employee_management.employee_list', compact('employees', 'departments', 'positions'));
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
