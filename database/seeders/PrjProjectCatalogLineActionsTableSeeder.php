<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrjProjectCatalogLineActionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('prj_project_catalog_line_actions')->delete();
        
        \DB::table('prj_project_catalog_line_actions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'GR1',
                'name' => 'Reducción del riesgo de desastres',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'GR2',
                'name' => 'Respuesta ante eventos peligrosos',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'GR3',
                'name' => 'Participación Comunitaria y Rendición de Cuentas',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'GR4',
                'name' => 'Recuperación post eventos',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'GR5',
                'name' => 'Análisis del Riesgo',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'GR6',
                'name' => 'Gestion de las telecomunicaciones',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'SC1',
                'name' => 'Promoción de la salud y prevención de enfermedades',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'SC2',
                'name' => 'Atención en salud',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'SC3',
                'name' => 'Salud mental y apoyo psicosocial',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'JU1',
                'name' => 'Vinculación comunitaria',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'JU2',
                'name' => 'Cultura de paz',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'JU3',
                'name' => 'Innovación social',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'PV1',
            'name' => 'Doctrina Institucional y Derecho Internacional Humanitario (DIH)',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'PV2',
                'name' => 'Restablecimiento del contacto familiar',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'PV3',
            'name' => 'Movilidad Humana (MH) - Protección, Género e Inclusión (PGI)',
                'description' => NULL,
                'plan_detail_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}