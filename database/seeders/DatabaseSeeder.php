<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DepartmentsTableSeeder;
use Database\Seeders\PositionsTableSeeder;
use Database\Seeders\EmployeesTableSeeder;
use Database\Seeders\ContributionsTableSeeder;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DepartmentsTableSeeder::class,
            PositionsTableSeeder::class,
            EmployeesTableSeeder::class,
            ContributionsTableSeeder::class,
        ]);
    }
}
