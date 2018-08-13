<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
        	'code_subject' => 'MAT-100',
        	'subject' => 'MATEMATICA BASICA',
        	'credits' => '4',
        	]);

        DB::table('subjects')->insert([
        	'code_subject' => 'ESP-100',
        	'subject' => 'LENGUA ESPAÑOL',
        	'credits' => '3',
        	]);

        DB::table('subjects')->insert([
        	'code_subject' => 'ORI-101',
        	'subject' => 'ORIENTACION ACADEMICA INSTITUCIONAL',
        	'credits' => '3',
        	]);
    }
}
