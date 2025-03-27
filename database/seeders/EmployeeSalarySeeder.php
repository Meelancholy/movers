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
            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'hourly_rate' => rand(15, 50),
                'monthly_salary' => rand(2000, 8000),
            ]);
        }
    }
}
