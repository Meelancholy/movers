<?php

// app/Http/Controllers/Api/EmployeeController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(Employee::all());
    }

    // app/Http/Controllers/Api/EmployeeController.php
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'department' => 'required|string',
            'position' => 'required|string',
            'bdate' => 'required|date',  // Ensure this is present
            'job_type' => 'required|string',
            'gender' => 'required|string',
            'status' => 'required|string',
            'contact' => 'required|string'
        ]);

        $employee = Employee::create($validated);

        return response()->json([
            'success' => true,
            'data' => $employee
        ], 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:employees,email,'.$employee->id,
            'department' => 'sometimes|string',
            'position' => 'sometimes|string',
            'bdate' => 'sometimes|date',
            'job_type' => 'sometimes|string',
            'gender' => 'sometimes|string',
            'status' => 'sometimes|string',
            'contact' => 'sometimes|string'
        ]);

        $employee->update($validated);

        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }

    public function search($query)
    {
        return response()->json(
            Employee::where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->get()
        );
    }

    public function byDepartment($department)
    {
        return response()->json(
            Employee::where('department', $department)->get()
        );
    }
    public function byPosition($position)
    {
        return response()->json(
            Employee::where('position', $position)->get()
        );
    }
}
