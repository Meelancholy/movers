<?php
namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department; // Include the Department model
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        // This method can be added to list all positions
        $positions = Position::with('department')->get(); // Eager load the department
        return view('hr1.employee_management.position_index', compact('positions'));
    }

    public function create()
    {
        $departments = Department::all(); // Get all departments for the dropdown
        return view('hr1.employee_management.position_create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:positions',
            'base_salary' => 'required|numeric',
            'department_id' => 'required|exists:departments,id', // Validate department ID
        ]);

        Position::create($request->all());
        return redirect()->route('employee.dashboard')->with('success', 'Position created successfully.');
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $departments = Department::all(); // Get all departments for the dropdown
        return view('hr1.employee_management.position_edit', compact('position', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:positions,title,'.$id,
            'base_salary' => 'required|numeric',
            'department_id' => 'required|exists:departments,id', // Validate department ID
        ]);

        $position = Position::findOrFail($id);
        $position->update($request->all());
        return redirect()->route('employee.dashboard')->with('success', 'Position updated successfully.');
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        return redirect()->route('employee.dashboard')->with('success', 'Position deleted successfully.');
    }
}
