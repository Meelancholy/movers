<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contribution; // Ensure you have a Contribution model

class ContributionsTableSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 20) as $index) {
            Contribution::create([
                'employee_id' => $index, // Assuming employee IDs are 1-20
                'philhealth' => (bool) rand(0, 1),
                'sss' => (bool) rand(0, 1),
                'pagibig' => (bool) rand(0, 1),
            ]);
        }
    }
}
