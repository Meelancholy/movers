<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name'); // Change to first_name
            $table->string('last_name');  // Add last_name
            $table->string('email')->unique();
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->string('status'); // active, inactive, on leave, terminated
            $table->string('contact')->nullable(); // If this is needed
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

