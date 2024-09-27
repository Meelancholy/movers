<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('position_id');
            $table->date('hire_date');
            $table->enum('status', ['active', 'terminated']);
            $table->string('contact_info');
            $table->string('address');
            $table->timestamps();
        });

        // Raw SQL foreign key constraint for position_id
        DB::statement('ALTER TABLE employees ADD CONSTRAINT fk_position_id FOREIGN KEY (position_id) REFERENCES positions(position_id) ON DELETE CASCADE');
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

