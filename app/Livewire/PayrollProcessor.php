<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Cycle;
use App\Models\Payroll;
use App\Models\PayrollAdjustment;
use Illuminate\Support\Facades\Storage;
use PDF;

class PayrollProcessor extends Component
{
    public $type;
    public $completed = false;
    public $successCount = 0;
    public $errors = [];
    public $cycle;
    public $currentProcessing = 0;
    public $totalToProcess = 0;

    public function mount()
    {
        $data = session('payroll_confirm_data', []);
        $this->type = $data['type'] ?? null;
        $employeeIds = $data['employee_ids'] ?? [];
        $cycleId = $data['cycle_id'] ?? null;

        if (!$this->type || empty($employeeIds) || !$cycleId) {
            return redirect()->route('payroll.index')->with('error', 'Invalid request');
        }

        $this->cycle = Cycle::find($cycleId);
        $this->totalToProcess = count($employeeIds);
        $this->processPayrolls($employeeIds);
    }

    protected function processPayrolls($employeeIds)
    {
        foreach ($employeeIds as $employeeId) {
            try {
                $employee = Employee::findOrFail($employeeId);
                $this->generatePayrollForEmployee($employee);
                $this->successCount++;
            } catch (\Exception $e) {
                $this->errors[] = "Failed to process {$employee->first_name} {$employee->last_name}: " . $e->getMessage();
            }

            $this->currentProcessing++;
        }

        $this->completed = true;
    }

    protected function generatePayrollForEmployee($employee)
    {
        $cycle = $this->cycle;

        if (Payroll::where('employee_id', $employee->id)
                  ->where('cycle_id', $cycle->id)
                  ->exists()) {
            throw new \Exception('Payroll already exists for this employee');
        }

        $salary = $employee->salary()->latest()->first();
        if (!$salary) {
            throw new \Exception('No salary information found');
        }

        $hoursWorked = (float)$employee->attendances()->sum('hours_worked');
        $baseGrossPay = $hoursWorked * $salary->hourly_rate;

        // Get adjustments with pivot data
        $employeeAdjustments = $employee->adjustments()
            ->withPivot('frequency')
            ->get();

        // Calculate adjustments
        $incentivesTotal = $this->calculateIncentives($baseGrossPay, $employeeAdjustments);
        $grossPay = $baseGrossPay + $incentivesTotal;
        $withholdingsTotal = $this->calculateWithholdings($grossPay, $employeeAdjustments);
        $annualIncome = $baseGrossPay * 12;

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
        $netPay = $grossPay - $withholdingsTotal - $tax;

        $filename = 'payrolls/payroll_'.$employee->id.'_'.$cycle->id.'_'.now()->format('YmdHis').'.pdf';

        // Create payroll record
        $payroll = Payroll::create([
            'cycle_id' => $cycle->id,
            'employee_id' => $employee->id,
            'base_pay' => $baseGrossPay,
            'gross_pay' => $grossPay,
            'tax' => $tax,
            'net_pay' => $netPay,
            'adjustments_total' => $withholdingsTotal,
            'hours_worked' => $hoursWorked,
            'pdf_path' => $filename,
            'status' => 'pending'
        ]);

        // Record all adjustments in payroll_adjustments
        $this->recordPayrollAdjustments($employee, $employeeAdjustments, $payroll, $grossPay);

        // Generate PDF
        $payrollData = $payroll->load([
            'employee',
            'cycle',
            'payrollAdjustments' => function($query) {
                $query->with(['adjustment', 'employee']);
            }
        ]);

        $pdf = PDF::loadView('payroll.pdf', ['payroll' => $payrollData]);

        if (!Storage::exists('payrolls')) {
            Storage::makeDirectory('payrolls');
        }

        Storage::put($filename, $pdf->output());
    }

    protected function recordPayrollAdjustments($employee, $adjustments, $payroll, $grossPay)
    {
        foreach ($adjustments as $adjustment) {
            $currentFrequency = $adjustment->pivot->frequency;
            $isInfinite = ($currentFrequency == -1);
            $amount = $this->calculateAdjustmentAmount($adjustment, $grossPay);

            // Create payroll adjustment record
            PayrollAdjustment::create([
                'payroll_id' => $payroll->id,
                'adjustment_id' => $adjustment->id,
                'employee_id' => $employee->id,
                'amount' => $amount,
                'type' => $adjustment->operation,
                'frequency_before' => $currentFrequency,
                'frequency_after' => $isInfinite ? -1 : max(0, $currentFrequency - 1),
                'adjustment_data' => json_encode([
                    'name' => $adjustment->name,
                    'description' => $adjustment->description,
                    'operation' => $adjustment->operation,
                    'percentage' => $adjustment->percentage,
                    'fixedamount' => $adjustment->fixedamount,
                ])
            ]);

            // Update frequency in employee_adjustment pivot table
            if (!$isInfinite) {
                $newFrequency = max(0, $currentFrequency - 1);

                if ($newFrequency <= 0) {
                    // Remove the adjustment if frequency reaches 0
                    $employee->adjustments()->detach($adjustment->id);
                } else {
                    // Update the frequency count
                    $employee->adjustments()->updateExistingPivot($adjustment->id, [
                        'frequency' => $newFrequency
                    ]);
                }
            }
        }
    }

    protected function calculateAdjustmentAmount($adjustment, $baseAmount)
    {
        return $adjustment->percentage
            ? $baseAmount * ($adjustment->percentage / 100)
            : $adjustment->fixedamount;
    }

    protected function calculateIncentives($grossPay, $employeeAdjustments)
    {
        $totalIncentives = 0;
        foreach ($employeeAdjustments as $adjustment) {
            if ($adjustment->operation === 'incentive') {
                $amount = $this->calculateAdjustmentAmount($adjustment, $grossPay);
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
                $amount = $this->calculateAdjustmentAmount($adjustment, $grossPay);
                $totalWithholdings += $amount;
            }
        }
        return $totalWithholdings;
    }

    public function render()
    {
        return view('livewire.payroll-processor');
    }
}
