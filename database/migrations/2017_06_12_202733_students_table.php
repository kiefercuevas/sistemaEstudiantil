<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('students', function (Blueprint $table) {
			$table->increments('id');
			$table->string('names', 45);
			$table->string('last_name', 45);
			$table->string('career', 100);
			$table->date('birthday')->nullable();
			$table->string('identity_card', 15)->nullable();
			$table->string('civil_status', 45)->nullable();
			$table->string('email', 180)->unique()->nullable();
			$table->string('shift', 20);
			$table->integer('inscribed_opportunity')->nullable();
			$table->boolean('debt')->nullable();
			$table->string('condition', 180);
			$table->string('Period',180);
			$table->string('spanish',180);
			$table->string('math',180);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('students');
	}
}
