<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GoalIndicatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('goal_indicators')->delete();
        
        \DB::table('goal_indicators')->insert(array (
            0 => 
            array (
                'id' => 12,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '12',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-12-01',
                'end_date' => '2022-12-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            1 => 
            array (
                'id' => 11,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '11',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-11-01',
                'end_date' => '2022-11-30',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            2 => 
            array (
                'id' => 10,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '10',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-10-01',
                'end_date' => '2022-10-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            3 => 
            array (
                'id' => 9,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '9',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-09-01',
                'end_date' => '2022-09-30',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            4 => 
            array (
                'id' => 8,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '8',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-08-01',
                'end_date' => '2022-08-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            5 => 
            array (
                'id' => 7,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '7',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-07-01',
                'end_date' => '2022-07-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            6 => 
            array (
                'id' => 6,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '6',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-06-01',
                'end_date' => '2022-06-30',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            7 => 
            array (
                'id' => 5,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '5',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-05-01',
                'end_date' => '2022-05-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            8 => 
            array (
                'id' => 4,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '4',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-04-01',
                'end_date' => '2022-04-30',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            9 => 
            array (
                'id' => 3,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '3',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-03-01',
                'end_date' => '2022-03-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            10 => 
            array (
                'id' => 2,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '2',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-02-01',
                'end_date' => '2022-02-28',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
            11 => 
            array (
                'id' => 1,
                'indicators_id' => 1,
                'goal_value' => NULL,
                'min' => NULL,
                'max' => NULL,
                'period' => '1',
                'actual_value' => NULL,
                'user_updated' => 1,
                'state' => NULL,
                'start_date' => '2022-01-01',
                'end_date' => '2022-01-31',
                'year' => 2022,
                'deleted_at' => NULL,
                'created_at' => '2022-03-15 15:20:47',
                'updated_at' => '2022-03-15 15:20:47',
            ),
        ));
        
        
    }
}