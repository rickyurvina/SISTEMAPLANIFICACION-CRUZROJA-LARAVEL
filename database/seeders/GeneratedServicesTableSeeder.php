<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneratedServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('generated_services')->delete();
        
        \DB::table('generated_services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '001',
                'name' => 'INTERNO',
                'description' => 'DESCRIPCION INTERNO',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '002',
                'name' => 'TRIAJE',
                'description' => 'DESCRIPCION TRIAJE',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '003',
                'name' => 'ETIQUETADO',
                'description' => 'DESCRIPCION ETIQUETADO',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '004',
                'name' => 'RECHEQUEO',
                'description' => 'DESCRIPCION RECHEQUEO',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}