<?php

namespace App\Livewire\EmployeeManagement;

use Livewire\Component;
use App\Models\Employee;

class EmployeeList extends Component
{
    public function render()
    {
        $employees = Employee::where('status', 'active')->get();

        return view('livewire.employee-management.employee-list', compact('employees'));
    }
    public function setInactive($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $employee->status = 'inactive';
        $employee->save();

        session()->flash('success', 'Employee set to inactive successfully.');

        $this->employees = Employee::where('status', 'active')->get(); // Refresh the employees list
    }
}
