<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '001',
                'name' => 'PLANIFICACION',
                'description' => NULL,
                'responsible' => 1,
                'parent_id' => NULL,
                'enabled' => true,
                'company_id' => 1,
                'created_at' => '2022-01-26 01:21:44',
                'updated_at' => '2022-01-26 01:21:44',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '002',
                'name' => 'FINANCIERO',
                'description' => NULL,
                'responsible' => 1,
                'parent_id' => NULL,
                'enabled' => true,
                'company_id' => 1,
                'created_at' => '2022-01-26 01:21:57',
                'updated_at' => '2022-01-26 01:21:57',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '003',
                'name' => 'PRESUPUESTO',
                'description' => NULL,
                'responsible' => 1,
                'parent_id' => NULL,
                'enabled' => true,
                'company_id' => 1,
                'created_at' => '2022-01-26 01:22:16',
                'updated_at' => '2022-01-26 01:22:23',
                'deleted_at' => '2022-01-26 01:22:23',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '003',
                'name' => 'AREAS ESENCIALES',
                'description' => NULL,
                'responsible' => 1,
                'parent_id' => NULL,
                'enabled' => true,
                'company_id' => 1,
                'created_at' => '2022-01-26 01:36:55',
                'updated_at' => '2022-01-26 01:36:55',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '001',
                'name' => 'PLANIFICACION',
                'description' => NULL,
                'responsible' => 1,
                'parent_id' => NULL,
                'enabled' => true,
                'company_id' => 2,
                'created_at' => '2022-01-26 03:51:22',
                'updated_at' => '2022-01-26 03:51:22',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '002',
                'name' => 'RRHH',
                'description' => NULL,
                'responsible' => 1,
                'parent_id' => NULL,
                'enabled' => true,
                'company_id' => 2,
                'created_at' => '2022-01-26 03:51:41',
                'updated_at' => '2022-01-26 03:51:41',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}