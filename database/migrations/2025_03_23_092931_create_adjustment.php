<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('adjustments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('adjustment'); // Adjustment type or name
            $table->string('rangestart')->nullable(); // Starting range for adjustment
            $table->string('rangeend')->nullable(); // Ending range for adjustment
            $table->string('operation'); // Operation to perform (e.g., add, subtract)
            $table->string('percentage')->nullable(); // Percentage value (if applicable)
            $table->string('fixedamount')->nullable(); // Fixed amount value (if applicable)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('adjustment'); // Drop the table if the migration is rolled back
    }
};
