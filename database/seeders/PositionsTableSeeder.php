<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position; // Ensure you have a Position model

class PositionsTableSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 20) as $index) {
            Position::create([
                'title' => 'Position ' . $index,
                'base_salary' => rand(30000, 100000), // Random salary between 30k and 100k
                'department_id' => rand(1, 20), // Assuming department IDs are 1-20
            ]);
        }
    }
}
