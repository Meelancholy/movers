<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeSalary;
use App\Models\Employee;

class EmployeeSalarySeeder extends Seeder
{
    public function run()
    {
        // Get all employees
        $employees = Employee::all();

        // Create salary records for each employee
        foreach ($employees as $employee) {
            // Determine salary based on position type
            $position = strtolower($employee->position);
            $department = strtolower($employee->department);

            if ($department === 'operations' && $position === 'driver') {
                // Driver salaries (PHP monthly)
                $monthlySalary = rand(15000, 25000);  // ₱15,000 - ₱25,000/month
                $hourlyRate = round($monthlySalary / 22 / 8, 2);  // 22 working days, 8 hours/day
            } elseif (str_contains($position, 'manager') || str_contains($position, 'lead') || str_contains($position, 'head')) {
                // Managerial positions
                $monthlySalary = rand(35000, 80000);  // ₱35,000 - ₱80,000/month
                $hourlyRate = round($monthlySalary / 22 / 8, 2);
            } elseif ($department === 'executive') {
                // Executive team
                $monthlySalary = rand(80000, 250000);  // ₱80,000 - ₱250,000/month
                $hourlyRate = round($monthlySalary / 22 / 8, 2);
            } else {
                // Regular office staff
                $monthlySalary = rand(18000, 40000);  // ₱18,000 - ₱40,000/month
                $hourlyRate = round($monthlySalary / 22 / 8, 2);
            }

            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'hourly_rate' => $hourlyRate,
                'monthly_salary' => $monthlySalary,
            ]);
        }
    }
}
