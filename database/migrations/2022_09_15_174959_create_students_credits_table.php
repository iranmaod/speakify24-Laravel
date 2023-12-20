<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_credits', function (Blueprint $table) {
            $table->bigIncrements('credit_id');
            $table->integer('user_id')->nullable();
			$table->decimal('hours', 5, 2)->default(10.2);
            $table->integer('lang_id')->nullable();
			$table->dateTime('start_time');
			$table->dateTime('end_time');
            $table->decimal('weekly_hours', 5, 2)->default(10.2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_credits');
    }
}
