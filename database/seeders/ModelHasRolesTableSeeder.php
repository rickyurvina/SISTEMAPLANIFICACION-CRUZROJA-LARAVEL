<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\Auth\\User',
                'model_id' => 1,
            ),
            1 => 
            array (
                'role_id' => 13,
                'model_type' => 'App\\Models\\Auth\\User',
                'model_id' => 3,
            ),
            2 => 
            array (
                'role_id' => 14,
                'model_type' => 'App\\Models\\Auth\\User',
                'model_id' => 5,
            ),
            3 => 
            array (
                'role_id' => 15,
                'model_type' => 'App\\Models\\Auth\\User',
                'model_id' => 4,
            ),
        ));
        
        
    }
}