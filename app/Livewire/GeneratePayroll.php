<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cycle;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\EmployeeSalary;
use App\Models\Adjustment;
use App\Models\PayrollAdjustment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GeneratePayroll extends Component
{
    use WithPagination;

    public $selectedCycleId = null;
    public $cycles;
    public $selectedCycle;
    public $employees;
    public $showGenerateConfirmation = false;
    public $employeeToGenerate = null;
    public $calculatedPayroll = [];

    // Cycle creation properties
    public $showCreateCycleForm = false;
    public $newCycle = [
        'start_date' => '',
        'end_date' => '',
        'payout_date' => '',
        'cut_off_date' => '',
    ];

    // Cycle deletion properties
    public $cycleToDelete = null;
    public $showDeleteModal = false;

    public function mount()
    {
        $this->loadCycles();
        $this->employees = Employee::all();
    }

    protected function loadCycles()
    {
        $this->cycles = Cycle::orderByDesc('start_date')->get();
        $this->selectedCycleId = optional($this->cycles->first())->id;
    }

    public function selectCycle($cycleId)
    {
        $this->selectedCycleId = $cycleId;
    }

    public function createCycle()
    {
        $this->validate([
            'newCycle.start_date' => 'required|date',
            'newCycle.end_date' => 'required|date|after:newCycle.start_date',
            'newCycle.cut_off_date' => 'required|date',
            'newCycle.payout_date' => 'required|date',
        ]);

        $overlappingCycle = Cycle::where(function ($query) {
            $query->whereBetween('start_date', [$this->newCycle['start_date'], $this->newCycle['end_date']])
                ->orWhereBetween('end_date', [$this->newCycle['start_date'], $this->newCycle['end_date']])
                ->orWhere(function ($query) {
                    $query->where('start_date', '<=', $this->newCycle['start_date'])
                        ->where('end_date', '>=', $this->newCycle['end_date']);
                });
        })->exists();

        if ($overlappingCycle) {
            $this->addError('newCycle.start_date', 'This cycle overlaps with an existing cycle.');
            $this->addError('newCycle.end_date', 'This cycle overlaps with an existing cycle.');
            return;
        }

        $cycle = Cycle::create([
            'start_date' => $this->newCycle['start_date'],
            'end_date' => $this->newCycle['end_date'],
            'cut_off_date' => $this->newCycle['cut_off_date'],
            'payout_date' => $this->newCycle['payout_date'],
            'status' => 'pending',
        ]);

        $this->loadCycles();
        $this->showCreateCycleForm = false;
        $this->reset('newCycle');
        session()->flash('message', 'Cycle created successfully.');
    }


    public function confirmDeleteCycle($cycleId)
    {
        $this->cycleToDelete = $cycleId;
        $this->showDeleteModal = true;
    }

    public function deleteCycle()
    {
        $cycle = Cycle::find($this->cycleToDelete);

        if ($cycle) {
            if ($cycle->payrolls()->exists()) {
                session()->flash('error', 'Cannot delete cycle with existing payrolls.');
                $this->showDeleteModal = false;
                return;
            }

            $cycle->delete();
            session()->flash('message', 'Cycle deleted successfully.');
            $this->loadCycles();
        }

        $this->showDeleteModal = false;
    }

    public function prepareGeneratePayroll($employeeId)
    {
        $cycle = Cycle::find($this->selectedCycleId);
        $employee = Employee::find($employeeId);

        if (!$cycle || !$employee) return;

        if (Payroll::where('employee_id', $employee->id)
                  ->where('cycle_id', $cycle->id)
                  ->exists()) {
            session()->flash('error', 'Payroll already exists for this employee in the selected cycle.');
            return;
        }

        $salary = $employee->salary()->latest()->first();
        if (!$salary) {
            session()->flash('error', 'No salary information found for this employee.');
            return;
        }

        $hoursWorked = (string) $employee->attendances()->sum('hours_worked');
        $baseGrossPay = (float)($hoursWorked * $salary->hourly_rate);

        $employeeAdjustments = $employee->adjustments()->withPivot('frequency')->get();
        $incentivesTotal = $this->calculateIncentives($baseGrossPay, $employeeAdjustments);
        $grossPay = $baseGrossPay + $incentivesTotal;
        $withholdingsTotal = $this->calculateWithholdings($grossPay, $employeeAdjustments);
        $netPay = $grossPay - $withholdingsTotal;

        $this->calculatedPayroll = [
            'base_pay' => $baseGrossPay,
            'gross_pay' => $grossPay,
            'adjustments_total' => $withholdingsTotal,
            'net_pay' => $netPay,
            'hours_worked' => $hoursWorked
        ];

        $this->employeeToGenerate = $employee;
        $this->showGenerateConfirmation = true;
    }

    public function confirmGeneratePayroll()
    {
        if (!$this->employeeToGenerate) return;

        $cycle = Cycle::find($this->selectedCycleId);
        $employee = $this->employeeToGenerate;
        $salary = $employee->salary()->latest()->first();

        if (!$salary) {
            session()->flash('error', 'No salary information found for this employee.');
            return;
        }

        $filename = 'payrolls/payroll_'.$employee->id.'_'.$cycle->id.'_'.now()->format('YmdHis').'.pdf';

        try {
            $payroll = Payroll::create([
                'cycle_id' => (string) $cycle->id,
                'employee_id' => (string) $employee->id,
                'base_pay' => (string) $this->calculatedPayroll['base_pay'],
                'gross_pay' => (string) $this->calculatedPayroll['gross_pay'],
                'net_pay' => (string) $this->calculatedPayroll['net_pay'],
                'adjustments_total' => (string) $this->calculatedPayroll['adjustments_total'],
                'hours_worked' => $this->calculatedPayroll['hours_worked'],
                'pdf_path' => $filename
            ]);

            $this->updateAdjustmentFrequencies(
                $employee,
                $employee->adjustments()->withPivot('frequency')->get(),
                $payroll
            );

            // Updated data loading with proper relationships
            $payrollData = $payroll->load([
                'employee',
                'cycle',
                'payrollAdjustments' => function($query) {
                    $query->with(['adjustment', 'employee']);
                }
            ]);

            $pdf = Pdf::loadView('payroll.pdf', ['payroll' => $payrollData]);

            if (!Storage::exists('payrolls')) {
                Storage::makeDirectory('payrolls');
            }

            Storage::put($filename, $pdf->output());

            $this->showGenerateConfirmation = false;
            $this->employeeToGenerate = null;
            $this->calculatedPayroll = [];

            session()->flash('message', 'Payroll generated for ' . $employee->first_name);
            $this->selectedCycle = $cycle->load('payrolls.employee');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate payroll: '.$e->getMessage());
        }
    }

    public function downloadPdf($payrollId)
    {
        try {
            // Load payroll with all necessary relationships
            $payroll = Payroll::with([
                'employee',
                'cycle',
                'payrollAdjustments' => function($query) {
                    $query->with(['adjustment', 'employee']);
                }
            ])->findOrFail($payrollId);

            // Check if PDF needs to be regenerated
            if (empty($payroll->pdf_path)) {
                $filename = 'payrolls/payroll_'.$payroll->employee_id.'_'.$payroll->cycle_id.'_'.now()->format('YmdHis').'.pdf';
                $pdf = Pdf::loadView('payroll.pdf', ['payroll' => $payroll]);
                Storage::put($filename, $pdf->output());
                $payroll->update(['pdf_path' => $filename]);
            }

            // Verify the file exists or regenerate it
            if (!Storage::exists($payroll->pdf_path)) {
                $filename = 'payrolls/payroll_'.$payroll->employee_id.'_'.$payroll->cycle_id.'_'.now()->format('YmdHis').'.pdf';
                $pdf = Pdf::loadView('payroll.pdf', ['payroll' => $payroll]);
                Storage::put($filename, $pdf->output());
                $payroll->update(['pdf_path' => $filename]);
            }

            return Storage::download($payroll->pdf_path);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to download PDF: '.$e->getMessage());
            return back();
        }
    }

    protected function updateAdjustmentFrequencies($employee, $adjustments, $payroll)
    {
        foreach ($adjustments as $adjustment) {
            $currentFrequency = $adjustment->pivot->frequency;
            $isInfinite = ($currentFrequency == -1);

            $amount = $this->calculateAdjustmentAmount($adjustment, $payroll->gross_pay);

            // Record the adjustment history (always create record, even for infinite frequency)
            PayrollAdjustment::create([
                'payroll_id' => $payroll->id,
                'adjustment_id' => $adjustment->id,
                'employee_id' => $employee->id,
                'amount' => $amount,
                'type' => $adjustment->operation,
                'frequency_before' => $currentFrequency,
                'frequency_after' => $isInfinite ? -1 : ($currentFrequency - 1),
                'adjustment_data' => json_encode([
                    'name' => $adjustment->name,
                    'description' => $adjustment->description,
                    'operation' => $adjustment->operation,
                    'percentage' => $adjustment->percentage,
                    'fixedamount' => $adjustment->fixedamount,
                ])
            ]);

            // Update or remove the adjustment
            if ($isInfinite) {
                // For infinite frequency, just ensure it stays at -1
                $employee->adjustments()->updateExistingPivot($adjustment->id, [
                    'frequency' => -1
                ]);
            } else {
                $newFrequency = $currentFrequency - 1;
                if ($newFrequency <= 0) {
                    $employee->adjustments()->detach($adjustment->id);
                } else {
                    $employee->adjustments()->updateExistingPivot($adjustment->id, [
                        'frequency' => $newFrequency
                    ]);
                }
            }
        }
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

    public function render()
    {
        $this->selectedCycle = Cycle::with(['payrolls' => function($query) {
            $query->with('employee');
        }])->find($this->selectedCycleId);

        return view('livewire.generate-payroll', [
            'employees' => $this->employees
        ]);
    }
}
