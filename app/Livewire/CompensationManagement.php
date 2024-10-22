<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;

class CompensationManagement extends Component
{
    use WithPagination;

    public $search = ''; // To hold the search input

    // Query string to persist the search input
    protected $queryString = ['search'];

    public function searchEmployees()
    {
        // Resets the pagination when a new search is performed
        $this->resetPage();
    }

    public function render()
    {
        // Fetch employees based on search input
        $employees = Employee::with(['contributions', 'deductions', 'bonuses'])
            ->where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.compensation-management', [
            'employees' => $employees,
        ]);
    }
}
