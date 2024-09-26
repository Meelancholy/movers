<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id('position_id');
            $table->string('position_name');
            $table->unsignedBigInteger('department_id');
            $table->decimal('base_salary', 10, 2);
            $table->timestamps();
        });

        // Adding the foreign key constraint using raw SQL
        DB::statement('ALTER TABLE positions ADD CONSTRAINT fk_department_id FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE CASCADE');
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
