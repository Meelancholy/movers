<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payroll;

class Payrollrecords extends Component
{
    use WithPagination;

    public $search = ''; // To hold the search input

    // Updating the query string to remember the search input during pagination
    protected $queryString = ['search'];

    public function searchEmployees()
    {
        // Resets pagination to the first page when search is initiated
        $this->resetPage();
    }

    public function render()
    {
        // Filter payrolls based on search query for employee's name
        $payrolls = Payroll::with('employee')
            ->whereHas('employee', function ($query) {
                if ($this->search) {
                    $query->where('first_name', 'like', '%' . $this->search . '%')
                          ->orWhere('last_name', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.payrollrecords', compact('payrolls'));
    }
}
