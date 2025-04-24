<?php

namespace App\Livewire;
// app/Http/Livewire/PayrollProcessor.php
use Livewire\Component;
use App\Models\Employee;
use App\Models\Cycle;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
                $employee = Employee::find($employeeId);

                // Call your existing payroll generation logic directly
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
            throw new \Exception('Payroll already exists');
        }

        $salary = $employee->salary()->latest()->first();
        if (!$salary) {
            throw new \Exception('No salary information found');
        }

        $hoursWorked = (string) $employee->attendances()->sum('hours_worked');
        $baseGrossPay = (float)($hoursWorked * $salary->hourly_rate);

        // Add your adjustment calculations here
        $incentivesTotal = 0; // Replace with your calculation
        $grossPay = $baseGrossPay + $incentivesTotal;
        $withholdingsTotal = 0; // Replace with your calculation
        $netPay = $grossPay - $withholdingsTotal;

        $filename = 'payrolls/payroll_'.$employee->id.'_'.$cycle->id.'_'.now()->format('YmdHis').'.pdf';

        $payroll = Payroll::create([
            'cycle_id' => (string) $cycle->id,
            'employee_id' => (string) $employee->id,
            'base_pay' => (string) $baseGrossPay,
            'gross_pay' => (string) $grossPay,
            'net_pay' => (string) $netPay,
            'adjustments_total' => (string) $withholdingsTotal,
            'hours_worked' => $hoursWorked,
            'pdf_path' => $filename,
            'status' => 'pending'
        ]);

        // Add your adjustment updates here if needed

        // Generate PDF
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
    }

    public function render()
    {
        return view('livewire.payroll-processor');
    }
}
