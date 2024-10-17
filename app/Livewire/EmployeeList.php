<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Livewire\WithPagination;

class EmployeeList extends Component
{
    use WithPagination;

    public $search = '';
    public $department_id = '';
    public $position_id = '';
    public $status = '';

    public function filterEmployees()
    {
        // This method can be used to apply filtering logic
        $this->resetPage(); // Resets the pagination to the first page
    }

    public function render()
    {
        $employees = Employee::query();

        if ($this->search) {
            $employees->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
            });
        }


        if ($this->department_id) {
            $employees->where('department_id', $this->department_id);
        }

        if ($this->position_id) {
            $employees->where('position_id', $this->position_id);
        }

        if ($this->status) {
            $employees->where('status', $this->status);
        }
        $employees = $employees->paginate(10);
        $departments = Department::all();
        $positions = Position::all();

        return view('livewire.employee-list', compact('employees', 'departments', 'positions'));
    }
}
