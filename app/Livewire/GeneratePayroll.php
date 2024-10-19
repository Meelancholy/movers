<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\Bonus;
use App\Models\Deduction;
use App\Models\Payroll;
use App\Services\ContributionService;

class GeneratePayroll extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    protected $contributionService;

    public function boot(ContributionService $contributionService)
    {
        $this->contributionService = $contributionService;
    }

    public function generatePayroll($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $contributions = $this->contributionService->calculateContributions($employee);
        $baseSalary = $contributions['salary'];

        $bonus = Bonus::where('employee_id', $employee->id)->sum('amount');
        $deduction = Deduction::where('employee_id', $employee->id)->sum('amount');

        $grossSalary = $baseSalary + $bonus;
        $tax = $contributions['tax'];
        $withholdings = $contributions['sssContribution']['employee_share'] +
                        $contributions['philhealth_employee_share'] +
                        $contributions['pagibig_employee_share'] +
                        $deduction +
                        $tax;
        $netSalary = $grossSalary - $withholdings;

        Payroll::create([
            'employee_id' => $employee->id,
            'salary' => $baseSalary,
            'gross_salary' => $grossSalary,
            'withholdings' => $withholdings,
            'net_salary' => $netSalary,
        ]);

        session()->flash('success', 'Payroll generated and saved for employee ID: ' . $employeeId);
    }

    public function render()
    {
        // Retrieve all employees and paginate
        $employees = Employee::with('position')->paginate(10);

        // Map employee data for the view using items() method
        $employeePayrollData = $employees->items(); // Get the items in the paginated collection

        $employeePayrollData = array_map(function ($employee) {
            $contributions = $this->contributionService->calculateContributions($employee);
            $baseSalary = $contributions['salary'];
            $bonus = Bonus::where('employee_id', $employee->id)->sum('amount');
            $deduction = Deduction::where('employee_id', $employee->id)->sum('amount');

            $grossSalary = $baseSalary + $bonus;
            $tax = $contributions['tax'];
            $withholdings = $contributions['sssContribution']['employee_share'] +
                            $contributions['philhealth_employee_share'] +
                            $contributions['pagibig_employee_share'] +
                            $deduction +
                            $tax;
            $netSalary = $grossSalary - $withholdings;

            return [
                'id' => $employee->id,
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'baseSalary' => $baseSalary,
                'grossSalary' => $grossSalary,
                'withholdings' => $withholdings,
                'netSalary' => $netSalary,
            ];
        }, $employeePayrollData); // Map the employee data to the new structure

        return view('livewire.generate-payroll', [
            'employees' => $employees, // Pass the paginated employees
            'employeePayrollData' => $employeePayrollData,
        ]);
    }


}
