<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section', 15);
            $table->boolean('status');
            $table->timeTz('time_first');
            $table->timeTz('time_last');
            $table->timeTz('second_time_first')->nullable();
            $table->timeTz('second_time_last')->nullable();
            $table->integer('quota');
            $table->string('day_one', 20);
            $table->string('day_two', 20)->nullable();
            $table->string('shift', 20);

            $table->integer('classrooms_id')->unsigned();
            $table->foreign('classrooms_id')->references('id')->on('classrooms');

            $table->integer('subjects_id')->unsigned();
            $table->foreign('subjects_id')->references('id')->on('subjects');

            $table->integer('academic_periods_id')->unsigned();
            $table->foreign('academic_periods_id')->references('id')->on('academic_periods');

            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users');
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
        Schema::dropIfExists('sections');
    }
}
