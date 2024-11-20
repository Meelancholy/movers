<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;

class EmployeeList extends Component
{
    public function render()
    {
        $employees = Employee::all();
        $departments = Department::all();
        $positions = Position::all();
        return view('livewire.employee-list', compact('employees', 'departments', 'positions'));
    }
}
