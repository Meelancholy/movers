<?php

namespace App\Http\Controllers;
use App\Models\Adjustment;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\EmployeeSalary;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function list()
    {
        return view('hr1.employee_management.employee_list');
    }
    public function archive()
    {
        $employees = Employee::where('status', 'inactive')->get();

        return view('hr1.employee_management.archive', compact('employees'));
    }
        public function active($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = 'active';
        $employee->save();

        return redirect()->back()->with('success', 'Employee set to active successfully.');
    }

    public function confirmation()
    {
        return view('hr1.employee_management.payroll-confirmation');
    }
    public function processor()
    {
        return view('hr1.employee_management.payroll-processor');
    }
// app/Http/Controllers/EmployeeController.php
public function edit($id)
{
    $employee = Employee::with(['salary', 'attendances', 'adjustments'])->findOrFail($id);
    $allAdjustments = Adjustment::all();
// Temporary debug in your controller
    return view('hr1.employee_management.employee_edit', compact('employee', 'allAdjustments'));
}
public function show($id)
{
    $employee = Employee::with(['salary', 'attendances', 'adjustments'])->findOrFail($id);
    $allAdjustments = Adjustment::all();
    $employee->bdate = \Carbon\Carbon::parse($employee->bdate);
    return view('hr1.employee_management.employee_show', compact('employee'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'status' => 'required|string',
        'contact' => 'required|string|min:11|max:11',
        'job_type' => 'required|string',
        'gender' => 'required|string',
        'position' => 'required|string',
        'department' => 'required|string',
        'bdate' => 'required|date',
        'adjustments.*.adjustment_id' => 'required|exists:adjustments,id',
        'adjustments.*.frequency' => 'required|integer|min:-12|max:12',
    ]);

    $employee = Employee::findOrFail($id);
    $employee->update($request->only(['first_name', 'last_name', 'status', 'contact', 'email']));

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
        if ($employee->status === 'active') {
            $employee->status = 'inactive';
        } elseif ($employee->status === 'inactive') {
            $employee->status = 'active';
        }
        $employee->save();
        return redirect()->route('employee.list')->with('success', 'Employee deleted successfully.');
    }
}
