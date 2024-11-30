<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Livewire\GeneratePayroll;
use App\Models\DeductionHistory;
use App\Models\BonusHistory;


class PayrollController extends Controller
{
    public function show($employeeId)
    {
        $employee = Employee::with('contributions', 'bonuses', 'deductions')->findOrFail($employeeId);
        $payrollData = (new GeneratePayroll)->calculateContributions($employee);

        return view('hr1.payroll.show', compact('payrollData', 'employee'));
    }

    public function generatePayroll()
    {
        return view('hr1.payroll.generate'); // This should load the Livewire component
    }

    public function finalizePayroll($employeeId)
    {
        // Fetch employee with contributions, bonuses, and deductions
        $employee = Employee::with(['contributions', 'bonuses', 'deductions'])->findOrFail($employeeId);

        // Instantiate the payroll component to calculate contributions
        $payrollComponent = new GeneratePayroll();
        $payrollData = $payrollComponent->calculateContributions($employee);

        // Create the payroll record
        $payroll = Payroll::create([
            'employee_id' => $employeeId,
            'salary' => $payrollData['baseSalary'],
            'gross_salary' => $payrollData['grossSalary'],
            'withholdings' => $payrollData['withholdings'],
            'net_salary' => $payrollData['netSalary'],
        ]);

        // Process bonuses
        foreach ($employee->bonuses as $bonus) {
            // Insert bonus history
            BonusHistory::create([
                'employee_id' => $employeeId,
                'payroll_id' => $payroll->id,
                'description' => $bonus->bonus_name,
                'amount' => $bonus->amount,
            ]);

            // Decrement frequency if greater than 0
            if ($bonus->frequency > 0) {
                $bonus->frequency--;
                if ($bonus->frequency == 0) {
                    $bonus->delete(); // Delete if frequency is 0
                } else {
                    $bonus->save(); // Save updated frequency
                }
            }
        }

        // Process deductions
        foreach ($employee->deductions as $deduction) {
            // Insert deduction history
            DeductionHistory::create([
                'employee_id' => $employeeId,
                'payroll_id' => $payroll->id,
                'description' => $deduction->deduction_name,
                'amount' => $deduction->amount,
            ]);

            // Decrement frequency if greater than 0
            if ($deduction->frequency > 0) {
                $deduction->frequency--;
                if ($deduction->frequency == 0) {
                    $deduction->delete(); // Delete if frequency is 0
                } else {
                    $deduction->save(); // Save updated frequency
                }
            }
        }

        // Redirect after successful payroll finalization
        return redirect()->route('payroll.generate')->with('success', 'Payroll finalized successfully!');
    }



    public function records()
    {
        return view('hr1.payroll.records');
    }
    public function viewRecord($id)
    {
        // Retrieve the payroll record by ID, along with the employee and bonuses
        $payroll = Payroll::with(['employee', 'bonusHistories','employee', 'deductionHistories'])->findOrFail($id);
        // Pass the payroll details and bonuses to the view
        return view('hr1.payroll.viewrecords', compact('payroll'));
    }
    public function dashboard()
    {
        // Fetch necessary data for the dashboard
        $totalPayrolls = Payroll::count(); // Total number of payroll records
        $totalGrossSalary = Payroll::sum('gross_salary'); // Total gross salary
        $totalNetSalary = Payroll::sum('net_salary'); // Total net salary

        // Optionally, you can retrieve recent payrolls or other statistics
        $recentPayrolls = Payroll::with('employee')->orderBy('created_at', 'desc')->take(5)->get();

        return view('hr1.payroll.dashboard', compact('totalPayrolls', 'totalGrossSalary', 'totalNetSalary', 'recentPayrolls'));
    }
}
