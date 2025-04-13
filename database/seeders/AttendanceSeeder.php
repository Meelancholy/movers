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

        foreach ($employees as $employee) {
            // Generate attendance records
            $isDriver = (strtolower($employee->department) === 'operations' && strtolower($employee->position)) === 'driver';

            Attendance::create([
                'employee_id' => $employee->id,
                'hours_worked' => $isDriver ? rand(8, 12) : rand(6, 9), // Drivers work longer hours
            ]);
        }
    }
}
