<?php

namespace App\Livewire;

// app/Http/Livewire/PayrollConfirmation.php
use Livewire\Component;
use App\Models\Employee;
use App\Models\Cycle;
use App\Models\Adjustment;

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

// In your Livewire component (e.g., PayrollConfirmation.php)
protected function calculateEmployeeSummary($employee)
{
    $hours = (float)$employee->attendances()->sum('hours_worked');
    $hourlyRate = optional($employee->salary()->latest()->first())->hourly_rate ?? 0;
    $basePay = $hours * $hourlyRate;

    $employeeAdjustments = $employee->adjustments()->get();


    // Calculate incentives and withholdings
    $incentives = $this->calculateIncentives($basePay, $employeeAdjustments);
    $withholdings = $this->calculateWithholdings($basePay + $incentives, $employeeAdjustments);
    $annualIncome = $basePay * 12;

    $tax = 0;

    if ($annualIncome <= 250000) {
        $tax = 0;
    } elseif ($annualIncome <= 400000) {
        $tax = ($annualIncome - 250000) * 0.15;
    } elseif ($annualIncome <= 800000) {
        $tax = 22500 + ($annualIncome - 400000) * 0.20;
    } elseif ($annualIncome <= 2000000) {
        $tax = 102500 + ($annualIncome - 800000) * 0.25;
    } elseif ($annualIncome <= 8000000) {
        $tax = 402500 + ($annualIncome - 2000000) * 0.30;
    } else {
        $tax = 2202500 + ($annualIncome - 8000000) * 0.35;
    }
    $tax = $tax / 12;
    $estimatedPay = $basePay + $incentives - $withholdings - $tax;


    // Prepare adjustments details
    $adjustments = [];
    foreach ($employeeAdjustments as $adj) {
        $amount = $this->calculateAdjustmentAmount($adj, $adj->operation === 'incentive' ? $basePay : ($basePay + $incentives));
        $adjustments[] = [
            'name' => $adj->adjustment,
            'type' => $this->getAdjustmentType($adj->operation),
            'amount' => $amount,
            'frequency' => $adj->pivot->frequency,
            'operation' => $adj->operation,
            'calculation' => $adj->percentage
                ? "{$adj->percentage}% of " . ($adj->operation === 'incentive' ? 'base pay' : 'gross pay')
                : "Fixed amount"
        ];
    }

    $this->summary = array_merge($this->summary, [
        'employee_count' => 1,
        'total_hours' => number_format($hours, 2),
        'hourly_rate' => number_format($hourlyRate, 2),
        'base_pay' => number_format($basePay, 2),
        'incentives' => number_format($incentives, 2),
        'withholdings' => number_format($withholdings, 2),
        'estimated_total' => number_format($estimatedPay, 2),
        'employee_name' => $employee->first_name.' '.$employee->last_name,
        'adjustments' => $adjustments,
        'tax' => $tax
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

    $this->employees = $query->with(['salary', 'attendances', 'adjustments' => function($q) {
        $q->withPivot('frequency');
    }])->get();

    $totalHours = 0;
    $totalAmount = 0;

    foreach ($this->employees as $employee) {
        $hours = (float)$employee->attendances->sum('hours_worked');
        $hourlyRate = optional($employee->salary)->hourly_rate ?? 0;
        $basePay = $hours * $hourlyRate;

        // Calculate adjustments for each employee
        $incentives = $this->calculateIncentives($basePay, $employee->adjustments);
        $withholdings = $this->calculateWithholdings($basePay + $incentives, $employee->adjustments);
        $annualIncome = $basePay * 12;

        $tax = 0;

        if ($annualIncome <= 250000) {
            $tax = 0;
        } elseif ($annualIncome <= 400000) {
            $tax = ($annualIncome - 250000) * 0.15;
        } elseif ($annualIncome <= 800000) {
            $tax = 22500 + ($annualIncome - 400000) * 0.20;
        } elseif ($annualIncome <= 2000000) {
            $tax = 102500 + ($annualIncome - 800000) * 0.25;
        } elseif ($annualIncome <= 8000000) {
            $tax = 402500 + ($annualIncome - 2000000) * 0.30;
        } else {
            $tax = 2202500 + ($annualIncome - 8000000) * 0.35;
        }
        $tax = $tax / 12;
        $estimatedPay = $basePay + $incentives - $withholdings - $tax;
        $adjustments = [];
        foreach ($employee->adjustments as $adj) {
            $amount = $this->calculateAdjustmentAmount($adj, $adj->operation === 'incentive' ? $basePay : ($basePay + $incentives));
            $adjustments[] = [
                'name' => $adj->adjustment,
                'type' => $this->getAdjustmentType($adj->operation),
                'amount' => $amount,
                'frequency' => $adj->pivot->frequency,
                'operation' => $adj->operation
            ];
        }

        $employee->summary = [
            'hours_worked' => number_format($hours, 2),
            'hourly_rate' => number_format($hourlyRate, 2),
            'base_pay' => number_format($basePay, 2),
            'incentives' => number_format($incentives, 2),
            'withholdings' => number_format($withholdings, 2),
            'estimated_pay' => number_format($estimatedPay, 2),
            'adjustments' => $adjustments,
            'tax' => $tax
        ];

        $totalHours += $hours;
        $totalAmount += $estimatedPay;
    }

    $this->summary = array_merge($this->summary, [
        'employee_count' => $this->employees->count(),
        'total_hours' => number_format($totalHours, 2),
        'estimated_total' => number_format($totalAmount, 2)
    ]);
}

protected function getAdjustmentType($operation)
{
    return match($operation) {
        'incentive' => 'addition',
        'deduction', 'contribution' => 'deduction',
        default => 'other'
    };
}
protected function calculateAdjustmentAmount($adjustment, $grossPay)
{
    return $adjustment->percentage
        ? $grossPay * ($adjustment->percentage / 100)
        : $adjustment->fixedamount;
}

protected function calculateIncentives($grossPay, $employeeAdjustments)
{
    $totalIncentives = 0;
    foreach ($employeeAdjustments as $adjustment) {
        if ($adjustment->operation === 'incentive') {
            $amount = $adjustment->percentage
                ? (float)$grossPay * ((float)$adjustment->percentage / 100)
                : (float)$adjustment->fixedamount;
            $totalIncentives += $amount;
        }
    }
    return $totalIncentives;
}

protected function calculateWithholdings($grossPay, $employeeAdjustments)
{
    $totalWithholdings = 0;
    foreach ($employeeAdjustments as $adjustment) {
        if (in_array($adjustment->operation, ['deduction', 'contribution'])) {
            $amount = $adjustment->percentage
                ? (float)$grossPay * ((float)$adjustment->percentage / 100)
                : (float)$adjustment->fixedamount;
            $totalWithholdings += $amount;
        }
    }
    return $totalWithholdings;
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
