<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrjProjectCatalogFundersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('prj_project_catalog_funders')->delete();
        
        \DB::table('prj_project_catalog_funders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '001',
                'name' => 'Cruz Roja Ecuatoriana',
                'type' => 'Fondos Propios',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '002',
                'name' => 'Personas Naturales',
                'type' => 'Nacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '003',
                'name' => 'Comunidad',
                'type' => 'Aporte comunitario',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '004',
                'name' => 'AECID - Agencia Española de Cooperación Internacional para el Desarrollo',
                'type' => 'Internacional - Público',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '005',
                'name' => 'ECHO - Departamento para la Ayuda Humanitaria de la Comunidad Europea',
                'type' => 'Internacional - Organismos',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '006',
                'name' => 'TRAGSA',
                'type' => 'Internacional - Público',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '007',
                'name' => 'Embajada Suiza - COSUDE',
                'type' => 'Internacional - Público',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '008',
                'name' => 'Banco Guayaquil',
                'type' => 'Nacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '009',
                'name' => 'Nestlé',
                'type' => 'Nacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '010',
                'name' => 'Banco Pichincha',
                'type' => 'Nacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '011',
                'name' => 'Produbanco',
                'type' => 'Nacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '012',
                'name' => 'Asociación Ríos',
                'type' => 'Nacional - ONG',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '013',
                'name' => 'USAID - Agencia de los Estados Unidos para el Desarrollo',
                'type' => 'Internacional - Público',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '014',
                'name' => 'Embajada de Japón',
                'type' => 'Internacional - Público',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '015',
                'name' => 'SC Johnson',
                'type' => 'Internacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '016',
                'name' => 'Johanniter',
                'type' => 'Internacional - ONG',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '017',
                'name' => 'Fundación Coca-Cola',
                'type' => 'Internacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => '018',
                'name' => 'ACNUR - Alto Comisionado de las Naciones Unidas para los Refugiados',
                'type' => 'Internacional - Organismos',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => '019',
                'name' => 'Bayer AG',
                'type' => 'Internacional - Privado',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => '020',
                'name' => 'Cruz Roja Española',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => '021',
                'name' => 'Cruz Roja Alemana',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => '022',
                'name' => 'Cruz Roja Italiana',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => '023',
                'name' => 'FICR - Federación Internacional de Sociedades de la Cruz Roja y de la Media Luna Roja',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => '024',
                'name' => 'Cruz Roja Alemana',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => '025',
                'name' => 'Cruz Roja Suiza',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => '026',
                'name' => 'CICR - Comité Internacional de la Cruz Roja',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => '027',
                'name' => 'Cruz Roja Americana',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => '028',
                'name' => 'Cruz Roja Colombiana',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => '029',
                'name' => 'Cruz Roja Canadiense',
                'type' => 'Movimiento Internacional de la Cruz Roja y de la Media Luna Roja',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => '030',
                'name' => 'BMZ - Ministerio Federal para la Cooperación y el Desarrollo Económico',
                'type' => 'Internacional - Público',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}