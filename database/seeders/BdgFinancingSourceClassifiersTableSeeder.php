<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BdgFinancingSourceClassifiersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bdg_financing_source_classifiers')->delete();
        
        \DB::table('bdg_financing_source_classifiers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '000',
                'description' => 'RECURSOS FISCALES',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '001',
                'description' => 'Recursos Fiscales',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '002',
                'description' => 'Recursos Fiscales Generados por las Instituciones',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '003',
                'description' => 'Recursos Provenientes de Preasignaciones',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '006',
                'description' => 'Recursos Provenientes De La Ley Orgánica de Solidaridad',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '201',
                'description' => 'Colocaciones Externas',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '202',
                'description' => 'Préstamos Externos',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '301',
                'description' => 'Colocaciones Internas',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '302',
                'description' => 'Préstamos Internos',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '601',
                'description' => 'Recursos de la Seguridad Social para Unidades Médicas',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '700',
                'description' => 'ASISTENCIA TÉCNICA Y DONACIONES',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '701',
                'description' => 'Asistencia Técnica y Donaciones',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '998',
                'description' => 'Anticipos de Ejercicios Anteriores',
                'enabled' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}