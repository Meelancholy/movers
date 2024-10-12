<?php


// database/migrations/YYYY_MM_DD_create_bonuses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusesTable extends Migration
{
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('bonus_name');
            $table->decimal('amount', 10, 2);
            $table->enum('bonus_type', ['one_time', 'recurring', 'recurring_indefinitely']);
            $table->string('frequency')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonuses');
    }
}
