<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $positions = Position::with('department')->get(); // Load positions with department info
        return view('hr1.positions.index', compact('positions'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $departments = Department::all(); // Load all departments for dropdown
        return view('hr1.positions.create', compact('departments'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,department_id',
            'base_salary' => 'required|numeric|min:0',
        ]);

        Position::create($request->all());

        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    // Display the specified resource
    public function show($id)
    {
        $position = Position::with('department')->findOrFail($id);
        return view('positions.show', compact('position'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $departments = Department::all();
        return view('hr1.positions.edit', compact('position', 'departments'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,department_id',
            'base_salary' => 'required|numeric|min:0',
        ]);

        $position = Position::findOrFail($id);
        $position->update($request->all());

        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }
}
