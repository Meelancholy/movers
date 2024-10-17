<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\ContributionService;
use App\Models\Bonus;
use App\Models\Deduction;
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
        // Retrieve all employees with their positions and contributions
        $employees = Employee::with('position', 'contributions')->get();

        // Initialize an array to store payroll data for each employee
        $employeePayrollData = [];

        foreach ($employees as $employee) {
            // Use ContributionService to calculate salary and contributions
            $contributions = $this->contributionService->calculateContributions($employee);

            // Extract values for easier reference
            $baseSalary = $contributions['salary'];  // Base salary from the service

            // Get total bonus for the employee from the 'bonuses' table
            $bonus = Bonus::where('employee_id', $employee->id)->sum('amount');
            $deduction = Deduction::where('employee_id', $employee->id)->sum('amount');

            // Calculate gross salary by adding the base salary and the bonus
            $grossSalary = $baseSalary + $bonus;

            // Get the tax value from the contributions array
            $tax = $contributions['tax'];

            // Calculate total withholdings including employee contributions and tax
            $withholdings = $contributions['sssContribution']['employee_share'] +
                            $contributions['philhealth_employee_share'] +
                            $contributions['pagibig_employee_share'] +
                            $deduction +
                            $tax; // Total withholdings

            // Calculate the net salary after deductions
            $netSalary = $grossSalary - $withholdings;

            // Prepare data to be passed to the view
            $employeePayrollData[] = [
                'id' => $employee->id,
                'name' => $employee->first_name . ' ' . $employee->last_name,  // Combine first name and last name
                'baseSalary' => $baseSalary,
                'grossSalary' => $grossSalary,
                'withholdings' => $withholdings,
                'netSalary' => $netSalary
            ];
        }

        // Pass the payroll data to the view
        return view('hr1.payroll.generate', compact('employeePayrollData'));
    }


}
