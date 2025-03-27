<?php

namespace App\Http\Controllers;
use App\Models\Adjustment;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function list()
    {
        return view('hr1.employee_management.employee_list');
    }
// app/Http/Controllers/EmployeeController.php
public function edit($id)
{
    $employee = Employee::with('adjustments')->findOrFail($id);
    $allAdjustments = Adjustment::all();

    return view('hr1.employee_management.employee_edit', compact('employee', 'allAdjustments'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'status' => 'required|string',
        'contact' => 'required|string|min:11|max:11',
        'adjustments.*.adjustment_id' => 'required|exists:adjustments,id',
        'adjustments.*.frequency' => 'required|integer|min:-12|max:12',
    ]);

    $employee = Employee::findOrFail($id);
    $employee->update($request->only(['first_name', 'last_name', 'status', 'contact']));

    // Sync adjustments
    $adjustmentsData = [];
    if ($request->has('adjustments')) {
        foreach ($request->adjustments as $adjustment) {
            $adjustmentsData[$adjustment['adjustment_id']] = ['frequency' => $adjustment['frequency']];
        }
    }

    $employee->adjustments()->sync($adjustmentsData);

    return redirect()->route('employee.list')->with('success', 'Employee updated successfully.');
}

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.list')->with('success', 'Employee deleted successfully.');
    }
}
