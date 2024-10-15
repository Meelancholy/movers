<?php


// CompensationManagement.php


namespace App\Livewire;


use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;


class CompensationManagement extends Component
{
    use WithPagination;


    public function render()
    {
      $employees = Employee::with(['contributions', 'deductions', 'bonuses'])
            ->paginate(10);


        return view('livewire.compensation-management', [
            'employees' => $employees,
        ]);
  }
}
