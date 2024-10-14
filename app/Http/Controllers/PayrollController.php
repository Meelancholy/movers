<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Show the Generate Payroll page with calculated values.
     */
    public function create()
    {
        // Get all employees with their positions and base salary
        $employees = Employee::with('position', 'bonuses')->get();

        // Calculate for each employee
        $employeePayrollData = $employees->map(function ($employee) {
            $baseSalary = $employee->position->base_salary;
            $totalBonus = $employee->bonuses->sum('amount'); // Assuming bonuses are linked via relation
            $tax = $this->calculateTax($baseSalary);
            $deductions = 0; // Add your logic here
            $benefits = 0; // Add your logic here
            $netSalary = $baseSalary + $totalBonus - $tax - $deductions - $benefits;

            return [
                'id' => $employee->id,
                'name' => $employee->last_name . ', ' . $employee->first_name,
                'baseSalary' => $baseSalary,
                'totalBonus' => $totalBonus,
                'tax' => $tax,
                'deductions' => $deductions,
                'benefits' => $benefits,
                'netSalary' => $netSalary,
            ];
        });

        // Pass calculated data to the view
        return view('hr1.payroll.generate', compact('employeePayrollData'));
    }

    /**
     * Calculate tax based on salary.
     */
    private function calculateTax($baseSalary)
    {
        $tax = 0;

        if ($baseSalary > 666667) {
            $tax = 200833.33 + ($baseSalary - 666667) * 0.35;
        } elseif ($baseSalary > 166667) {
            $tax = 40833.33 + ($baseSalary - 166667) * 0.30;
        } elseif ($baseSalary > 66667) {
            $tax = 10833.33 + ($baseSalary - 66667) * 0.25;
        } elseif ($baseSalary > 33333) {
            $tax = 2500 + ($baseSalary - 33333) * 0.20;
        } elseif ($baseSalary > 20833) {
            $tax = ($baseSalary - 20833) * 0.15;
        }

        return $tax;
    }
}
