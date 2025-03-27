<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Adjustment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmployeeManagementSeeder extends Seeder
{
    public function run()
    {
        // Temporarily disable foreign key constraints
        Schema::disableForeignKeyConstraints();

        // Clear existing data in the correct order
        DB::table('employee_adjustment')->truncate();
        DB::table('adjustments')->truncate();
        DB::table('employees')->truncate();

        // Re-enable foreign key constraints
        Schema::enableForeignKeyConstraints();

        // Seed Employees
        $employees = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'juan.delacruz@example.com',
                'contact' => '09171234567',
                'status' => 'active',
                'department' => 'IT',
                'position' => 'Software Developer',
                'bdate' => '1990-05-15',
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria.santos@example.com',
                'contact' => '09187654321',
                'status' => 'active',
                'department' => 'HR',
                'position' => 'HR Manager',
                'bdate' => '1985-08-22',
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Reyes',
                'email' => 'pedro.reyes@example.com',
                'contact' => '09179876543',
                'status' => 'on leave',
                'department' => 'Finance',
                'position' => 'Accountant',
                'bdate' => '1988-11-30',
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        // Seed Adjustments (make sure you have at least 3 adjustments)
        $adjustments = [
            [
                'adjustment' => 'Transportation Allowance',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'add',
                'percentage' => null,
                'fixedamount' => '1500.00'
            ],
            [
                'adjustment' => 'Meal Allowance',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'add',
                'percentage' => null,
                'fixedamount' => '2000.00'
            ],
            [
                'adjustment' => 'Tax Deduction',
                'rangestart' => '10000',
                'rangeend' => '50000',
                'operation' => 'subtract',
                'percentage' => '5.00',
                'fixedamount' => null
            ],
            [
                'adjustment' => 'SSS Contribution',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'subtract',
                'percentage' => '4.50',
                'fixedamount' => null
            ],
            [
                'adjustment' => 'Performance Bonus',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'add',
                'percentage' => '10.00',
                'fixedamount' => null
            ]
        ];

        foreach ($adjustments as $adjustment) {
            Adjustment::create($adjustment);
        }

        // Attach adjustments to employees
        $employees = Employee::all();
        $adjustments = Adjustment::all();

        foreach ($employees as $employee) {
            // Get a random number between 1 and the total number of adjustments
            $numAdjustments = rand(1, min(3, count($adjustments)));

            // Safely get random adjustments
            $employeeAdjustments = $adjustments->random($numAdjustments)
                ->mapWithKeys(function ($adjustment) {
                    return [$adjustment->id => ['frequency' => rand(1, 3)]];
                })->toArray();

            $employee->adjustments()->attach($employeeAdjustments);
        }
    }
}
