<?php

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
            $table->string('frequency')->nullable();
            $table->boolean('processed')->default(false); // New field for tracking processing status
            $table->date('date_processed')->nullable(); // New field for processing date
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deductions');
    }
}