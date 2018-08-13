<?php

use Illuminate\Database\Seeder;

class RollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('rolls')->insert([
            'roll' => 'Administrador',
        ]);
        
        DB::table('rolls')->insert([
            'roll' => 'Profesor',
        ]);

        DB::table('rolls')->insert([
            'roll' => 'Empleado',
        ]);

        

    }
}
