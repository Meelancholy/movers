<?php
// database/migrations/2023_09_26_000000_create_departments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id'); // Primary Key
            $table->string('department_name');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
