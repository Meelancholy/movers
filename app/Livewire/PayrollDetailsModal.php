<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payroll;

class PayrollDetailsModal extends Component
{
    public $showModal = false;
    public $payroll;

    protected $listeners = ['showPayrollDetails' => 'show'];

    public function show($payrollId)
    {
        $this->payroll = Payroll::with([
            'employee',
            'cycle',
            'payrollAdjustments' => function($query) {
                $query->with(['adjustment', 'employee']);
            }
        ])->findOrFail($payrollId);

        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.payroll-details-modal');
    }
}
