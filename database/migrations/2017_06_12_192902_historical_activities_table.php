<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistoricalActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historical_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity', 45);
            $table->string('description', 90);
            $table->date('date');
            $table->timeTz('time');

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
        Schema::dropIfExists('historical_activities');
    }
}
