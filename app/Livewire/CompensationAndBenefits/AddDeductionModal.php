<?php

namespace App\Livewire\CompensationAndBenefits;

use App\Models\Deduction;
use App\Models\Employee;
use Livewire\Component;

class AddDeductionModal extends Component
{
    public $isModalOpen = false;
    public $employee_id, $deduction_name, $amount, $deduction_type = 'one_time', $frequency;
    public $employees;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'deduction_name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:1',
        'deduction_type' => 'required|string|in:one_time,recurring,recurring_indefinitely',
        'frequency' => 'nullable|integer|min:1|required_if:deduction_type,recurring',
    ];

    public function mount()
    {
        $this->employees = Employee::all();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function store()
    {
        $this->validate();

        $frequency = null;
        switch ($this->deduction_type) {
            case 'one_time':
                $frequency = 1;
                break;
            case 'recurring':
                $frequency = $this->frequency;
                break;
            case 'recurring_indefinitely':
                $frequency = -1;
                break;
        }

        // Create or update deduction record
        Deduction::updateOrCreate(
            [
                'employee_id' => $this->employee_id,
                'deduction_name' => $this->deduction_name,
                'amount' => $this->amount,
                'frequency' => $frequency,
            ]
        );

        $this->closeModal();
        return redirect()->route('compensation.index')->with('success', 'Deduction added successfully.');
    }

    public function resetFields()
    {
        $this->employee_id = null;
        $this->deduction_name = null;
        $this->amount = null;
        $this->deduction_type = 'one_time';
        $this->frequency = null;
    }

    public function render()
    {
        return view('livewire.compensation-and-benefits.add-deduction-modal');
    }
}
