<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\ContributionService;
use App\Models\Bonus;
use App\Models\Deduction;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $contributionService;

    public function __construct(ContributionService $contributionService)
    {
        $this->contributionService = $contributionService;
    }

    public function generatePayroll()
    {
        return view('hr1.payroll.generate'); // This should load the Livewire component
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            // Add any other validation rules here if necessary
        ]);

        // Get the employee ID from the request
        $employeeId = $request->input('employee_id');

        // Find the employee by their ID
        $employee = Employee::with('position', 'contributions')->findOrFail($employeeId);

        // Use ContributionService to calculate salary and contributions
        $contributions = $this->contributionService->calculateContributions($employee);

        // Get bonuses and deductions for the employee
        $bonuses = Bonus::where('employee_id', $employeeId)->get();
        $deductions = Deduction::where('employee_id', $employeeId)->get();

        // Sum up total bonus and deductions
        $totalBonus = $bonuses->sum('amount');
        $totalDeduction = $deductions->sum('amount');

        // Calculate gross salary by adding base salary and total bonus
        $grossSalary = $contributions['salary'] + $totalBonus;
        $salary = $contributions['salary'];

        // Calculate total withholdings
        $withholdings = $contributions['sssContribution']['employee_share'] +
                        $contributions['philhealth_employee_share'] +
                        $contributions['pagibig_employee_share'] +
                        $totalDeduction +
                        $contributions['tax'];

        // Calculate the net salary after deductions
        $netSalary = $grossSalary - $withholdings;

        // Store a new payroll record in the database (allow multiple records per employee)
        Payroll::create([
            'employee_id' => $employeeId,
            'salary' => $salary,
            'gross_salary' => $grossSalary,
            'withholdings' => $withholdings,
            'net_salary' => $netSalary,
        ]);

        // Decrease the frequency of bonuses and deductions
        $this->updateBonusAndDeductionFrequency($bonuses, $deductions);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Payroll generated successfully for ' . $employee->first_name . ' ' . $employee->last_name);
    }

    protected function updateBonusAndDeductionFrequency($bonuses, $deductions)
    {
        // Update frequency for bonuses
        foreach ($bonuses as $bonus) {
            if ($bonus->frequency > 0) {
                $bonus->frequency--;

                // Delete bonus if frequency becomes zero
                if ($bonus->frequency == 0) {
                    $bonus->delete();
                } else {
                    $bonus->save();
                }
            }
        }

        // Update frequency for deductions
        foreach ($deductions as $deduction) {
            if ($deduction->frequency > 0) {
                $deduction->frequency--;

                // Delete deduction if frequency becomes zero
                if ($deduction->frequency == 0) {
                    $deduction->delete();
                } else {
                    $deduction->save();
                }
            }
        }
    }

    public function records(Request $request)
    {
        $payrolls = Payroll::with('employee')
            ->when($request->employee_name, function ($query) use ($request) {
                $query->whereHas('employee', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->employee_name . '%')
                      ->orWhere('last_name', 'like', '%' . $request->employee_name . '%');
                });
            })
            ->get();

        return view('hr1.payroll.records', compact('payrolls'));
    }
}
