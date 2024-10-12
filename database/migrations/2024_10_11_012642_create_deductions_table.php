<?php

// database/migrations/YYYY_MM_DD_create_deductions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    public function up()
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('deduction_name');
            $table->decimal('amount', 10, 2);
            $table->enum('deduction_type', ['one_time', 'recurring', 'recurring_indefinitely']);
            $table->string('frequency')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deductions');
    }
}
