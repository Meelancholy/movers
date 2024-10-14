<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class CompensationManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $deductionsSortOrder = 'asc';
    public $bonusesSortOrder = 'asc';

    protected $queryString = ['search'];

    public function render()
    {
        // Fetch employees with their contributions, deductions, and bonuses
        $employees = Employee::with(['contributions', 'deductions', 'bonuses'])
            ->when($this->search, function($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->when($this->deductionsSortOrder, function($query) {
                $query->withSum('deductions', 'amount')
                      ->orderBy('deductions_sum_amount', $this->deductionsSortOrder);
            })
            ->when($this->bonusesSortOrder, function($query) {
                $query->withSum('bonuses', 'amount')
                      ->orderBy('bonuses_sum_amount', $this->bonusesSortOrder);
            })
            ->paginate(10);

        return view('livewire.compensation-management', [
            'employees' => $employees
        ]);
    }

    public function sort($column)
    {
        if ($column === 'deductions') {
            $this->deductionsSortOrder = $this->deductionsSortOrder === 'asc' ? 'desc' : 'asc';
        }

        if ($column === 'bonuses') {
            $this->bonusesSortOrder = $this->bonusesSortOrder === 'asc' ? 'desc' : 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
