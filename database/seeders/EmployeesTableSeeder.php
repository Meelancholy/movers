<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee; // Ensure you have an Employee model

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 20) as $index) {
            Employee::create([
                'first_name' => 'First' . $index,
                'last_name' => 'Last' . $index,
                'email' => 'employee' . $index . '@example.com',
                'department_id' => rand(1, 20), // Random department ID
                'position_id' => rand(1, 20), // Random position ID
                'status' => 'active',
                'contact' => '123-456-789' . $index, // Example contact
            ]);
        }
    }
}
