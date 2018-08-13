<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('first_midterm_date_from');
            $table->dateTime('first_midterm_date_to');
            $table->dateTime('second_midterm_date_from');
            $table->dateTime('second_midterm_date_to');
            $table->dateTime('pratice_score_date_from');
            $table->dateTime('pratice_score_date_to');
            $table->dateTime('final_exam_date_from');
            $table->dateTime('final_exam_date_to');
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
        Schema::dropIfExists('qualification_dates');
    }
}
