<?php

namespace Database\Seeders\Strategy;

use Illuminate\Database\Seeder;

class PlanRegisteredTemplateDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plan_registered_template_details')->delete();
        
        \DB::table('plan_registered_template_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'plan_id' => 1,
                'plan_template_detail_id' => 1,
                'parent_id' => NULL,
                'level' => 1,
                'order' => 1,
                'name' => 'Objetivos Estrategicos',
                'indicators' => true,
                'cre_objective' => true,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:37:12',
                'updated_at' => '2022-01-26 04:37:12',
                'articulations' => false,
                'program' => false,
            ),
            1 => 
            array (
                'id' => 2,
                'plan_id' => 1,
                'plan_template_detail_id' => 2,
                'parent_id' => 1,
                'level' => 2,
                'order' => 1,
                'name' => 'Objetivos Especificos',
                'indicators' => true,
                'cre_objective' => false,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:37:12',
                'updated_at' => '2022-01-26 04:37:12',
                'articulations' => true,
                'program' => false,
            ),
            2 => 
            array (
                'id' => 3,
                'plan_id' => 1,
                'plan_template_detail_id' => 3,
                'parent_id' => 2,
                'level' => 3,
                'order' => 1,
                'name' => 'Programas',
                'indicators' => false,
                'cre_objective' => false,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:37:12',
                'updated_at' => '2022-01-26 04:37:12',
                'articulations' => false,
                'program' => true,
            ),
            3 => 
            array (
                'id' => 4,
                'plan_id' => 1,
                'plan_template_detail_id' => 4,
                'parent_id' => 3,
                'level' => 4,
                'order' => 1,
                'name' => 'Resultados',
                'indicators' => true,
                'cre_objective' => false,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:37:12',
                'updated_at' => '2022-01-26 04:37:12',
                'articulations' => false,
                'program' => false,
            ),
        ));
        
        
    }
}