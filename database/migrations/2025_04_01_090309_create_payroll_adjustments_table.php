<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained()->cascadeOnDelete();
            $table->foreignId('adjustment_id')->constrained()->cascadeOnDelete(); // This is critical
            $table->decimal('amount', 10, 2);
            $table->string('type'); // 'incentive' or 'deduction'
            $table->integer('frequency_before');
            $table->integer('frequency_after');
            $table->foreignId('employee_id')->constrained();
            $table->json('adjustment_data')->nullable(); // If using JSON fallback
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_adjustments');
    }
};
