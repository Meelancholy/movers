<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payroll;
use App\Models\Cycle;

class PayrollRecords extends Component
{
    use WithPagination;

    public $selectedCycleId = '';
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'selectedCycleId' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        $cycles = Cycle::orderBy('start_date', 'desc')->get();

        $payrolls = Payroll::with(['employee', 'cycle', 'payrollAdjustments.adjustment'])
            ->when($this->selectedCycleId, function ($query) {
                $query->where('cycle_id', $this->selectedCycleId);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                      ->orWhere('last_name', 'like', '%'.$this->search.'%')
                      ->orWhere('employee_id', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.payroll-records', [
            'payrolls' => $payrolls,
            'cycles' => $cycles,
        ]);
    }
}
