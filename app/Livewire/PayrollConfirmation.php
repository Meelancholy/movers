<?php

namespace App\Livewire;

// app/Http/Livewire/PayrollConfirmation.php
use Livewire\Component;
use App\Models\Employee;
use App\Models\Cycle;

class PayrollConfirmation extends Component
{
    public $type;
    public $employees = [];
    public $cycle;
    public $employee; // For individual
    public $filters = [];

    public $summary = [
        'cycle' => 'Not available',
        'department' => 'All Departments',
        'position' => 'All Positions',
        'employee_count' => 0,
        'total_hours' => 0,
        'estimated_total' => '0.00',
        'employee_name' => '',
        'hourly_rate' => '0.00'
    ];

    public function mount()
    {
        $this->type = session('payroll_generation_type', 'bulk');
        $data = session('payroll_generation_data', []);

        // Initialize with default values
        $this->summary = [
            'cycle' => 'Not available',
            'department' => $data['department'] ?? 'All Departments',
            'position' => $data['position'] ?? 'All Positions',
            'employee_count' => 0,
            'total_hours' => 0,
            'estimated_total' => '0.00',
            'employee_name' => '',
            'hourly_rate' => '0.00'
        ];

        $this->cycle = Cycle::find($data['cycle_id'] ?? null);

        if ($this->cycle) {
            $this->summary['cycle'] = $this->cycle->start_date->format('M d, Y').' - '.$this->cycle->end_date->format('M d, Y');
        }

        if ($this->type === 'individual') {
            $this->employee = Employee::find($data['employee_id'] ?? null);
            if ($this->employee) {
                $this->calculateEmployeeSummary($this->employee);
            }
        } else {
            $this->calculateBulkSummary($data);
        }
    }

    protected function calculateEmployeeSummary($employee)
    {
        $hours = (float)$employee->attendances()->sum('hours_worked');
        $hourlyRate = optional($employee->salary()->latest()->first())->hourly_rate ?? 0;

        $this->summary = array_merge($this->summary, [
            'employee_count' => 1,
            'total_hours' => $hours,
            'estimated_total' => number_format($hours * $hourlyRate, 2),
            'employee_name' => $employee->first_name.' '.$employee->last_name,
            'hourly_rate' => number_format($hourlyRate, 2)
        ]);
    }

    protected function calculateBulkSummary($data)
    {
        $query = Employee::whereDoesntHave('payrolls', function($q) {
            $q->where('cycle_id', $this->cycle->id);
        });

        if (!empty($data['department'])) {
            $query->where('department', $data['department']);
        }

        if (!empty($data['position'])) {
            $query->where('position', $data['position']);
        }

        $employees = $query->with('salary')->get();
        $totalHours = 0;
        $totalAmount = 0;

        foreach ($employees as $employee) {
            $hours = (float)$employee->attendances()->sum('hours_worked');
            $hourlyRate = optional($employee->salary)->hourly_rate ?? 0;
            $totalHours += $hours;
            $totalAmount += $hours * $hourlyRate;
        }

        $this->summary = array_merge($this->summary, [
            'employee_count' => $employees->count(),
            'total_hours' => $totalHours,
            'estimated_total' => number_format($totalAmount, 2)
        ]);

        $this->employees = $employees;
    }
    public function confirm()
    {
        // Store data for processing
        session()->put('payroll_confirm_data', [
            'type' => $this->type,
            'employee_ids' => $this->type === 'individual'
                ? [$this->employee->id]
                : $this->employees->pluck('id')->toArray(),
            'cycle_id' => $this->cycle->id
        ]);

        return redirect()->route('payroll.process');
    }

    public function cancel()
    {
        return redirect()->route('payroll.generate'); // Your main payroll route
    }

    public function render()
    {
        return view('livewire.payroll-confirmation');
    }
}
