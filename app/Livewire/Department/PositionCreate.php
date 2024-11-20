<?php

namespace App\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use App\Models\Position;

class PositionCreate extends Component
{
    public $name;
    public $base_salary;
    public $department_id;
    public $departments;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'base_salary' => 'required|numeric|min:0',
        'department_id' => 'required|exists:departments,id',
    ];

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function submit()
    {
        $this->validate();

        // Store the new position
        Position::create([
            'name' => $this->name,
            'base_salary' => $this->base_salary,
            'department_id' => $this->department_id,
        ]);

        // Reset fields
        $this->reset();

        return redirect()->route('employee.dashboard')->with('success', 'Employee added successfully!');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.department.position-create');
    }
}
