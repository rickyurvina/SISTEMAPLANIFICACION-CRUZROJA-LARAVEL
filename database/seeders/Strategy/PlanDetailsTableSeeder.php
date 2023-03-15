<?php

namespace Database\Seeders\Strategy;

use Illuminate\Database\Seeder;

class PlanDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plan_details')->delete();
        
        \DB::table('plan_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 1,
                'parent_id' => NULL,
                'code' => '1',
                'name' => 'Promover la construcción de comunidades resilientes para aliviar y prevenir el sufrimiento humano.',
                'level' => 1,
                'mission_objective' => true,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:37:36',
                'updated_at' => '2022-01-26 04:37:36',
            ),
            1 => 
            array (
                'id' => 2,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 1,
                'parent_id' => NULL,
                'code' => '2',
                'name' => ' Impulsar el desarrollo de la Sociedad Nacional mediante transformaciones estratégicas que permitan mejorar su desempeño',
                'level' => 1,
                'mission_objective' => true,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:38:01',
                'updated_at' => '2022-01-26 04:38:01',
            ),
            2 => 
            array (
                'id' => 3,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 1,
                'code' => '1',
                'name' => 'Fortalecer las capacidades de las personas para anticipar las crisis, superarlas y recuperarse rápidamente de ellas.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:39:01',
                'updated_at' => '2022-01-26 04:39:01',
            ),
            3 => 
            array (
                'id' => 4,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 1,
                'code' => '2',
                'name' => 'Promover espacios de empoderamiento a las personas para el goce de condiciones de vida sana y segura, con dignidad y posibilidades de prosperar.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:39:14',
                'updated_at' => '2022-01-26 04:39:14',
            ),
            4 => 
            array (
                'id' => 5,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 1,
                'code' => '3',
                'name' => 'Promover espacios de convivencia diversos para la construcción de comunidades inclusivas y no violentas.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:39:25',
                'updated_at' => '2022-01-26 04:39:25',
            ),
            5 => 
            array (
                'id' => 6,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 2,
                'code' => '1',
                'name' => 'Generar el desarrollo integral del voluntariado mediante entrenamiento, profesionalización, sostenibilidad y fidelidad.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:39:44',
                'updated_at' => '2022-01-26 04:39:44',
            ),
            6 => 
            array (
                'id' => 7,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 2,
                'code' => '2',
                'name' => 'Asegurar el financiamiento de la Sociedad Nacional que permita desarrollar sus operaciones de manera sostenible.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:39:57',
                'updated_at' => '2022-01-26 04:39:57',
            ),
            7 => 
            array (
                'id' => 8,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 2,
                'code' => '3',
                'name' => 'Fortalecer la Sociedad Nacional en la gestión administrativa financiera que le permita prestar servicios oportunos, de calidad y sostenibles.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:40:09',
                'updated_at' => '2022-01-26 04:40:09',
            ),
            8 => 
            array (
                'id' => 9,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 2,
                'parent_id' => 2,
                'code' => '4',
                'name' => 'Impulsar el cumplimiento de la planificación estratégica y el desarrollo de la Sociedad Nacional.',
                'level' => 2,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:40:20',
                'updated_at' => '2022-01-26 04:40:20',
            ),
            9 => 
            array (
                'id' => 10,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 3,
                'parent_id' => 3,
                'code' => '1',
                'name' => 'Gestión del Riesgo de Desastres',
                'level' => 3,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:45:24',
                'updated_at' => '2022-01-26 04:45:24',
            ),
            10 => 
            array (
                'id' => 11,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 4,
                'parent_id' => 10,
                'code' => '1',
            'name' => 'Al 2025, más de 1 000 000 de personas alcanzadas con acciones misionales de GRED (reducción, respuesta y recuperación).',
                'level' => 4,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:45:36',
                'updated_at' => '2022-01-26 04:45:36',
            ),
            11 => 
            array (
                'id' => 12,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 4,
                'parent_id' => 10,
                'code' => '2',
            'name' => 'Al 2025, la SN han formado al personal humanitario en temas de gestión del riesgo de desastres (reducción, respuesta y recuperación).',
                'level' => 4,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:45:46',
                'updated_at' => '2022-01-26 04:45:46',
            ),
            12 => 
            array (
                'id' => 13,
                'plan_id' => 1,
                'plan_registered_template_detail_id' => 4,
                'parent_id' => 10,
                'code' => '3',
                'name' => 'Al 2025, al menos el 85% de satisfacción de las personas alcanzadas con los servicios de GRED.',
                'level' => 4,
                'mission_objective' => false,
                'organizational_development' => false,
                'perspective' => NULL,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:45:57',
                'updated_at' => '2022-01-26 04:45:57',
            ),
        ));
        
        
    }
}