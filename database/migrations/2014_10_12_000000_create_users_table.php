<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('names', 45);
            $table->string('last_name', 45);
            $table->string('office_phone', 20)->nullable();
            $table->string('personal_phone', 20)->nullable();
            $table->string('cellphone', 20)->nullable();
            $table->longText('address')->nullable();
            $table->string('identity_card', 15);
            $table->string('gender', 15);
            $table->string('civil_status', 25);
            $table->string('email', 180)->unique();
            $table->string('password', 280);
            $table->boolean('status');

            $table->integer('rolls_id')->unsigned();

            $table->foreign('rolls_id')->references('id')->on('rolls');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
