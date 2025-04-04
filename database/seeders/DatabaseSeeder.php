<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EmployeeManagementSeeder::class,
            AttendanceSeeder::class,
            EmployeeSalarySeeder::class,
            CyclesSeeder::class,
        ]);
    }
}
