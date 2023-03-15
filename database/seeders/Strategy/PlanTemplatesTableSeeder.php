<?php

namespace Database\Seeders\Strategy;

use Illuminate\Database\Seeder;

class PlanTemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plan_templates')->delete();
        
        \DB::table('plan_templates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'plan_type' => 'Estrategia CRE',
                'description' => 'Plantilla Estrategia CRE',
                'vision' => true,
                'mission' => true,
                'temporality' => true,
                'status' => true,
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:27:14',
                'updated_at' => '2022-01-26 04:27:14',
            ),
        ));
        
        
    }
}