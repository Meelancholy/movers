<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeSalary;
use App\Models\Employee;

class EmployeeSalarySeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $position = strtolower($employee->position);
            $department = strtolower($employee->department);

            if ($department === 'operations' && $position === 'driver') {
                $monthlySalary = rand(15000, 25000);
                $hourlyRate = round($monthlySalary / 22 / 8, 2);
            } elseif (str_contains($position, 'manager') || str_contains($position, 'lead') || str_contains($position, 'head')) {
                $monthlySalary = rand(35000, 80000);
                $hourlyRate = round($monthlySalary / 22 / 8, 2);
            } elseif ($department === 'executive') {
                $monthlySalary = rand(80000, 250000);
                $hourlyRate = round($monthlySalary / 22 / 8, 2);
            } else {
                $monthlySalary = rand(18000, 40000);
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
