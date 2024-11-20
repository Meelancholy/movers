<?php

namespace App\Livewire\Department;
use App\Models\Department;
use Livewire\Component;

class DepartmentCreate extends Component
{
    public $isModalOpen = false;
    public $name;

    // Open the modal
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    // Close the modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Store the department
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        // Store the department
        Department::create([
            'name' => $this->name,
        ]);
        return redirect()->route('employee.dashboard')->with('success', 'Employee added successfully!');
    }
    public function render()
    {
        return view('livewire.department.department-create');
    }
}
