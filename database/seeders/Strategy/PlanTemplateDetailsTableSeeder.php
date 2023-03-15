<?php

namespace Database\Seeders\Strategy;

use Illuminate\Database\Seeder;

class PlanTemplateDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plan_template_details')->delete();
        
        \DB::table('plan_template_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'plan_template_id' => 1,
                'parent_id' => NULL,
                'level' => 1,
                'order' => 1,
                'name' => 'Objetivos Estrategicos',
                'indicators' => true,
                'cre_objective' => true,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:28:07',
                'updated_at' => '2022-01-26 04:28:07',
                'articulations' => false,
                'program' => false,
            ),
            1 => 
            array (
                'id' => 2,
                'plan_template_id' => 1,
                'parent_id' => 1,
                'level' => 2,
                'order' => 1,
                'name' => 'Objetivos Especificos',
                'indicators' => true,
                'cre_objective' => false,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:28:31',
                'updated_at' => '2022-01-26 04:28:31',
                'articulations' => true,
                'program' => false,
            ),
            2 => 
            array (
                'id' => 3,
                'plan_template_id' => 1,
                'parent_id' => 2,
                'level' => 3,
                'order' => 1,
                'name' => 'Programas',
                'indicators' => false,
                'cre_objective' => false,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:34:53',
                'updated_at' => '2022-01-26 04:34:53',
                'articulations' => false,
                'program' => true,
            ),
            3 => 
            array (
                'id' => 4,
                'plan_template_id' => 1,
                'parent_id' => 3,
                'level' => 4,
                'order' => 1,
                'name' => 'Resultados',
                'indicators' => true,
                'cre_objective' => false,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:35:53',
                'updated_at' => '2022-01-26 04:35:53',
                'articulations' => false,
                'program' => false,
            ),
        ));
        
        
    }
}