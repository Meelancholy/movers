<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        // Get all employees
        $employees = Employee::all();

        // Create attendance records for the past 30 days for each employee
        foreach ($employees as $employee) {
            Attendance::create([
                'employee_id' => $employee->id,
                'hours_worked' => rand(4, 12), // Random hours worked between 4 and 12
            ]);
        }
    }
}
