<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrjProjectCatalogAssistantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('prj_project_catalog_assistants')->delete();
        
        \DB::table('prj_project_catalog_assistants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '001',
                'name' => 'CICR - Comité Internacional de la Cruz Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '002',
                'name' => 'Cruz Roja Alemana',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '003',
                'name' => 'Cruz Roja Americana',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '004',
                'name' => 'Cruz Roja Canadiense',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '005',
                'name' => 'Cruz Roja Colombiana',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '006',
                'name' => 'Cruz Roja Española',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '007',
                'name' => 'Cruz Roja Italiana',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '008',
                'name' => 'Cruz Roja Suiza',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '009',
                'name' => 'FICR - Federación Internacional de Sociedades de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}