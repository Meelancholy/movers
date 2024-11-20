<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class EmployeeCreate extends Component
{
    public $first_name, $last_name, $email, $contact, $status, $department_id, $position_id;
    public $departments, $positions;

    // Load departments and positions
    public function mount()
    {
        $this->departments = Department::all();
        $this->positions = Position::all(); // Load all positions initially
    }

    // Validate form data
    protected function validateForm()
    {
        ([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => ['email', Rule::unique('employees', 'email')],
            'department_id' => 'exists:departments,id',
            'position_id' => 'exists:positions,id',
            'contact' => 'string|max:11',
        ]);
    }

    // Handle form submission
    public function submitForm()
    {
        // Validate input
        $this->validateForm();

        // Create employee record
        Employee::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact' => $this->contact,
            'status' => "active",
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
        ]);
        return redirect()->route('employee.list')->with('success', 'Employee added successfully!');
    }

    public function render()
    {
        return view('livewire.employee-create');
    }
}
