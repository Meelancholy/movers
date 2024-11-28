<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;

class CompensationManagement extends Component
{
    public function render()
    {
        // Fetch all employees without filtering or paginating
        $employees = Employee::with(['contributions', 'deductions', 'bonuses'])->get();

        return view('livewire.compensation-management', [
            'employees' => $employees,
        ]);
    }
}
