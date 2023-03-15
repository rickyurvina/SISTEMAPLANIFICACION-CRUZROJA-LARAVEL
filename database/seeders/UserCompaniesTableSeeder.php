<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserCompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

//        \DB::table('user_companies')->delete();
        
        \DB::table('user_companies')->insert(array (
            0 => 
            array (
                'user_id' => 1,
                'company_id' => 3,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            2 => 
            array (
                'user_id' => 1,
                'company_id' => 2,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            3 => 
            array (
                'user_id' => 2,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            4 => 
            array (
                'user_id' => 3,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            5 => 
            array (
                'user_id' => 4,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            6 => 
            array (
                'user_id' => 5,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            7 => 
            array (
                'user_id' => 6,
                'company_id' => 2,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            8 => 
            array (
                'user_id' => 7,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            9 => 
            array (
                'user_id' => 8,
                'company_id' => 2,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            10 => 
            array (
                'user_id' => 9,
                'company_id' => 2,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            11 => 
            array (
                'user_id' => 10,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            12 => 
            array (
                'user_id' => 11,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            13 => 
            array (
                'user_id' => 12,
                'company_id' => 2,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            14 => 
            array (
                'user_id' => 13,
                'company_id' => 1,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
            15 => 
            array (
                'user_id' => 14,
                'company_id' => 2,
                'user_type' => 'App\\Models\\Auth\\User',
            ),
        ));
        
        
    }
}