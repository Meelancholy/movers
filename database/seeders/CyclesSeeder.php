<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CyclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table first
        Schema::disableForeignKeyConstraints();
        DB::table('cycles')->truncate();
        Schema::enableForeignKeyConstraints();

        $cycles = [
            [
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(1),
                'payment_date' => Carbon::now(),
                'status' => 'completed',
                'total' => '12500.00',
            ],
            [
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(29),
                'payment_date' => null,
                'status' => 'processing',
                'total' => '0.00',
            ],
            [
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(59),
                'payment_date' => null,
                'status' => 'pending',
                'total' => '0.00',
            ],
        ];

        DB::table('cycles')->insert($cycles);
    }
}
