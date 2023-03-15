<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

//        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            1 => 
            array (
                'id' => 2,
                'parent_id' => 1,
                'level' => 2,
                'domain' => '',
                'enabled' => true,
                'created_at' => '2022-01-26 03:50:02',
                'updated_at' => '2022-01-26 03:50:02',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'level' => 3,
                'domain' => '',
                'enabled' => true,
                'created_at' => '2022-01-26 03:50:28',
                'updated_at' => '2022-01-26 03:50:28',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}