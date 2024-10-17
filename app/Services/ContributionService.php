<?php
namespace App\Services;

class ContributionService
{
    public function calculateContributions($employee)
    {
        $salary = $employee->position ? $employee->position->base_salary : 0;
        $philhealth_employee_share = 0;
        $philhealth_employer_share = 0;
        $sssContribution = ['employee_share' => 0, 'employer_share' => 0];
        $pagibig_employee_share = 0;
        $pagibig_employer_share = 0;

        $philhealthContribution = $employee->contributions->firstWhere('philhealth', 1);
        $sssContributionData = $employee->contributions->firstWhere('sss', 1);
        $pagibigContribution = $employee->contributions->firstWhere('pagibig', 1);

        // PhilHealth Calculation
        if ($philhealthContribution && $philhealthContribution->philhealth == 1) {
            if ($salary >= 10000) {
                $philhealth_total = min($salary * 0.05, 5000);
                $philhealth_employee_share = $philhealth_total / 2;
                $philhealth_employer_share = $philhealth_total / 2;
            }
        }

        // SSS Calculation
        if ($sssContributionData && $sssContributionData->sss == 1) {
            if ($salary >= 4000) {
                $sss_employee_share = $salary <= 30000 ? $salary * 0.045 : 30000 * 0.045;
                $sss_employer_share = $salary <= 30000 ? $salary * 0.095 : 30000 * 0.095;
                $sssContribution = [
                    'employee_share' => $sss_employee_share,
                    'employer_share' => $sss_employer_share,
                    'total_contribution' => $sss_employee_share + $sss_employer_share,
                ];
            }
        }

        // Pag-IBIG Calculation
        if ($pagibigContribution && $pagibigContribution->pagibig == 1) {
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

        $tax = 0;

        if ($taxable_income <= 20833) {
            $tax = 0;
        } elseif ($taxable_income <= 33332) {
            $tax = ($taxable_income - 20833) * 0.15;
        } elseif ($taxable_income <= 66666) {
            $tax = 2500 + ($taxable_income - 33333) * 0.20;
        } elseif ($taxable_income <= 166666) {
            $tax = 10833.33 + ($taxable_income - 66667) * 0.25;
        } elseif ($taxable_income <= 666666) {
            $tax = 40833.33 + ($taxable_income - 166667) * 0.30;
        } else {
            $tax = 200833.33 + ($taxable_income - 666667) * 0.35;
        }

        // Return all contributions including the calculated tax
        return compact(
            'salary',
            'sssContribution',
            'philhealth_employee_share',
            'philhealth_employer_share',
            'pagibig_employee_share',
            'pagibig_employer_share',
            'taxable_income',
            'tax'
        );
    }
}
