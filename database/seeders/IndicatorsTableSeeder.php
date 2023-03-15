<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IndicatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('indicators')->delete();
        
        \DB::table('indicators')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => NULL,
                'name' => 'INIDCADOR 1',
                'code' => 'IND1',
                'total_goal_value' => NULL,
                'total_actual_value' => NULL,
                'user_id' => 4,
                'start_date' => '2022-01-01',
                'end_date' => '2022-12-28',
                'f_start_date' => '2022-01-01',
                'f_end_date' => '2022-12-31',
                'base_line' => NULL,
                'type' => 'Manual',
                'indicator_units_id' => 1,
                'indicator_sources_id' => 15,
                'thresholds_id' => 1,
                'threshold_type' => 'Ascending',
                'baseline_year' => NULL,
                'results' => 'ASDSA',
                'indicatorable_id' => 11,
                'indicatorable_type' => 'App\\Models\\Strategy\\PlanDetail',
                'frequency' => '12',
                'documents' => NULL,
                'goals_closed' => NULL,
                'company_id' => 1,
                'threshold_properties' => '[{"state":"Danger","max":"70"},{"state":"Warning","min":"70","max":"85"},{"state":"Success","min":"85"}]',
                'type_of_aggregation' => 'sum',
                'category' => 'Táctico',
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
                'national' => false,
            ),
        ));
        
        
    }
}