<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Modify the query to filter employees based on search input
        $employees = Employee::with('position')
            ->when($search, function($query, $search) {
                return $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhereHas('position', function($query) use ($search) {
                        $query->where('position_name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return view('hr1.employees.index', compact('employees', 'search'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('hr1.employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,position_id',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,terminated',
            'contact_info' => 'required|string',
            'address' => 'required|string',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $positions = Position::all();
        return view('hr1.employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,position_id',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,terminated',
            'contact_info' => 'required|string',
            'address' => 'required|string',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
