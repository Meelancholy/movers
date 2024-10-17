<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department; // Ensure you have a Department model

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 20) as $index) {
            Department::create([
                'name' => 'Department ' . $index,
            ]);
        }
    }
}
