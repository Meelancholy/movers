<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\Bonus;
use App\Models\Deduction;

class GeneratePayroll extends Component
{
    use WithPagination;

    public $search = '';

    public function searchEmployees()
    {
        $this->resetPage(); // Reset pagination to the first page on search
    }

    public function show($employeeId)
    {
        return redirect()->route('payroll.show', ['employeeId' => $employeeId]);
    }

    public function render()
    {
        $employees = Employee::query()
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                      ->orWhere('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
            ->with(['position', 'contributions']) // Eager load the position and contributions
            ->paginate(10);

        $employeePayrollData = $employees->map(function ($employee) {
            return $this->calculateContributions($employee);
        })->filter();

        return view('livewire.generate-payroll', [
            'employees' => $employees,
            'employeePayrollData' => $employeePayrollData,
        ]);
    }

    public function calculateContributions($employee)
    {
        $salary = $employee->position ? $employee->position->base_salary : 0;
        $philhealth_employee_share = $philhealth_employer_share = 0;
        $sssContribution = ['employee_share' => 0, 'employer_share' => 0];
        $pagibig_employee_share = $pagibig_employer_share = 0;

        // PhilHealth Calculation
        $philhealthContribution = $employee->contributions->firstWhere('philhealth', 1);
        if ($philhealthContribution) {
            if ($salary >= 10000) {
                $philhealth_total = min($salary * 0.05, 5000);
                $philhealth_employee_share = $philhealth_total / 2;
                $philhealth_employer_share = $philhealth_total / 2;
            }
        }

        // SSS Calculation
        $sssContributionData = $employee->contributions->firstWhere('sss', 1);
        if ($sssContributionData) {
            if ($salary >= 4000) {
                $sss_employee_share = $salary <= 30000 ? $salary * 0.045 : 30000 * 0.045;
                $sss_employer_share = $salary <= 30000 ? $salary * 0.095 : 30000 * 0.095;
                $sssContribution = [
                    'employee_share' => $sss_employee_share,
                    'employer_share' => $sss_employer_share,
                ];
            }
        }

        // Pag-IBIG Calculation
        $pagibigContribution = $employee->contributions->firstWhere('pagibig', 1);
        if ($pagibigContribution) {
            $monthly_compensation = min($salary, 5000);
            if ($monthly_compensation <= 1500) {
                $pagibig_employee_share = $monthly_compensation * 0.01;
                $pagibig_employer_share = $monthly_compensation * 0.02;
            } else {
                $pagibig_employee_share = $monthly_compensation * 0.02;
                $pagibig_employer_share = $monthly_compensation * 0.02;
            }
        }

        $taxable_income = $salary - $sssContribution['employee_share'] - $philhealth_employee_share - $pagibig_employee_share;

        // Tax Calculation
        $tax = $this->calculateTax($taxable_income);

        // Calculate bonus and deductions
        $bonus = Bonus::where('employee_id', $employee->id)->sum('amount');
        $deduction = Deduction::where('employee_id', $employee->id)->sum('amount');

        $grossSalary = $salary + $bonus;
        $withholdings = $sssContribution['employee_share'] +
                        $philhealth_employee_share +
                        $pagibig_employee_share +
                        $deduction +
                        $tax;
        $netSalary = $grossSalary - $withholdings;

        return [
            'id' => $employee->id,
            'name' => $employee->first_name . ' ' . $employee->last_name,
            'baseSalary' => $salary,
            'grossSalary' => $grossSalary,
            'withholdings' => $withholdings,
            'netSalary' => $netSalary,
            'bonuses' => $bonus, // Include bonuses details
            'deductions' => $deduction, // Include deductions details
            'tax' => $tax, // Include tax details
            'sssContribution' => $sssContribution, // Include SSS contribution details
            'philhealth' => [
                'employee_share' => $philhealth_employee_share,
                'employer_share' => $philhealth_employer_share,
            ],
            'pagibig' => [
                'employee_share' => $pagibig_employee_share,
                'employer_share' => $pagibig_employer_share,
            ],
        ];
    }

    public function calculateTax($taxable_income)
    {
        if ($taxable_income <= 20833) {
            return 0;
        } elseif ($taxable_income <= 33332) {
            return ($taxable_income - 20833) * 0.15;
        } elseif ($taxable_income <= 66666) {
            return 2500 + ($taxable_income - 33333) * 0.20;
        } elseif ($taxable_income <= 166666) {
            return 10833.33 + ($taxable_income - 66667) * 0.25;
        } elseif ($taxable_income <= 666666) {
            return 40833.33 + ($taxable_income - 166667) * 0.30;
        } else {
            return 200833.33 + ($taxable_income - 666667) * 0.35;
        }
    }

}
