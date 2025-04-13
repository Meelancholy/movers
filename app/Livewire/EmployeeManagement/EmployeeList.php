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
}
