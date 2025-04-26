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
    // Add this property at the top of your component
    public $showBulkGenerateConfirmation = false;
    public $selectedDepartment = '';
    public $selectedPosition = '';
    // Cycle creation properties
    public $showCreateCycleForm = false;
    public $newCycle = [
        'start_date' => '',
        'end_date' => '',
        'payout_date' => '',
        'cut_off_date' => '',
    ];

    // Replace the delete methods with these edit methods
    public $editingCycleId = null;
    public $showEditModal = false;
    public $form = [
        'start_date' => '',
        'end_date' => '',
        'cut_off_date' => '',
        'payout_date' => ''
    ];
    public function mount()
    {
        $this->loadCycles();
        $this->employees = Employee::where('status', 'active')->get();
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


    public function editCycle($cycleId)
    {
        $this->editingCycleId = $cycleId;
        $cycle = Cycle::find($cycleId);

        if ($cycle) {
            $this->form = [
                'start_date' => $cycle->start_date->format('Y-m-d'),
                'end_date' => $cycle->end_date->format('Y-m-d'),
                'cut_off_date' => $cycle->cut_off_date->format('Y-m-d'),
                'payout_date' => $cycle->payout_date->format('Y-m-d')
            ];
            $this->showEditModal = true;
        }
    }
    public function updateCycle()
    {
        $this->validate([
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date|after_or_equal:form.start_date',
            'form.cut_off_date' => 'required|date|after_or_equal:form.start_date|before_or_equal:form.end_date',
            'form.payout_date' => 'required|date|after_or_equal:form.end_date'
        ]);

        // Check for overlapping cycles (excluding the current cycle being edited)
        $overlappingCycle = Cycle::where('id', '!=', $this->editingCycleId)
            ->where(function($query) {
                $query->whereBetween('start_date', [$this->form['start_date'], $this->form['end_date']])
                      ->orWhereBetween('end_date', [$this->form['start_date'], $this->form['end_date']])
                      ->orWhere(function($q) {
                          $q->where('start_date', '<=', $this->form['start_date'])
                            ->where('end_date', '>=', $this->form['end_date']);
                      });
            })
            ->first();

        if ($overlappingCycle) {
            $this->addError('overlap', 'This cycle overlaps with an existing cycle ('.$overlappingCycle->start_date->format('M d').' - '.$overlappingCycle->end_date->format('M d, Y').'). Please adjust the dates.');
            return;
        }

        $cycle = Cycle::find($this->editingCycleId);

        if ($cycle) {
            $cycle->update([
                'start_date' => $this->form['start_date'],
                'end_date' => $this->form['end_date'],
                'cut_off_date' => $this->form['cut_off_date'],
                'payout_date' => $this->form['payout_date']
            ]);

            session()->flash('message', 'Cycle updated successfully.');
            $this->loadCycles();
        }

        $this->showEditModal = false;
        $this->reset(['editingCycleId', 'form']);
    }
    // In your main payroll component
    public function prepareGenerate($employeeId = null)
    {
        // Store in session whether this is bulk or individual
        session()->put('payroll_generation_type', $employeeId ? 'individual' : 'bulk');

        // Store filters and employee ID
        session()->put('payroll_generation_data', [
            'employee_id' => $employeeId,
            'department' => $this->selectedDepartment,
            'position' => $this->selectedPosition,
            'cycle_id' => $this->selectedCycleId
        ]);

        return redirect()->route('payroll.confirmation');
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
                'pdf_path' => $filename,
                'status' => 'pending'
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
    public function prepareBulkGeneratePayroll()
    {
        $this->showBulkGenerateConfirmation = true;
    }

    public function confirmBulkGeneratePayroll()
    {
        $this->showBulkGenerateConfirmation = false;

        $cycle = Cycle::find($this->selectedCycleId);
        if (!$cycle) {
            session()->flash('error', 'Selected cycle not found.');
            return;
        }

        // Get filtered employees without payroll for this cycle
        $query = Employee::whereDoesntHave('payrolls', function($query) use ($cycle) {
            $query->where('cycle_id', $cycle->id);
        });

        // Apply department filter if selected
        if ($this->selectedDepartment) {
            $query->where('department', $this->selectedDepartment);
        }

        // Apply position filter if selected
        if ($this->selectedPosition) {
            $query->where('position', $this->selectedPosition);
        }

        $employees = $query->get();

        if ($employees->isEmpty()) {
            session()->flash('message', 'No employees match the selected filters or all filtered employees already have payroll for this cycle.');
            return;
        }

        $successCount = 0;
        $errorMessages = [];

        foreach ($employees as $employee) {
            try {
                $this->prepareGeneratePayroll($employee->id);
                $this->confirmGeneratePayroll();
                $successCount++;
            } catch (\Exception $e) {
                $errorMessages[] = "Failed to generate payroll for {$employee->first_name}: " . $e->getMessage();
            }
        }

        if ($successCount > 0) {
            session()->flash('message', "Successfully generated payroll for {$successCount} employees.");
        }

        if (!empty($errorMessages)) {
            session()->flash('error', implode('<br>', $errorMessages));
        }

        $this->selectedCycle = $cycle->fresh()->load('payrolls.employee');
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
            $query->with(['employee' => function($employeeQuery) {
                $employeeQuery->where('status', 'active');
            }]);
        }])->find($this->selectedCycleId);

        return view('livewire.generate-payroll', [
            'employees' => $this->employees
        ]);
    }
}
