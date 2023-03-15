<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserDepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_departments')->delete();
        
        \DB::table('user_departments')->insert(array (
            0 => 
            array (
                'user_id' => 2,
                'department_id' => 1,
                'company_id' => 1,
            ),
            1 => 
            array (
                'user_id' => 3,
                'department_id' => 2,
                'company_id' => 1,
            ),
            2 => 
            array (
                'user_id' => 4,
                'department_id' => 2,
                'company_id' => 1,
            ),
            3 => 
            array (
                'user_id' => 5,
                'department_id' => 4,
                'company_id' => 1,
            ),
            4 => 
            array (
                'user_id' => 6,
                'department_id' => 5,
                'company_id' => 2,
            ),
            5 => 
            array (
                'user_id' => 7,
                'department_id' => 1,
                'company_id' => 1,
            ),
            6 => 
            array (
                'user_id' => 8,
                'department_id' => 6,
                'company_id' => 2,
            ),
            7 => 
            array (
                'user_id' => 9,
                'department_id' => 5,
                'company_id' => 2,
            ),
            8 => 
            array (
                'user_id' => 10,
                'department_id' => 1,
                'company_id' => 1,
            ),
            9 => 
            array (
                'user_id' => 11,
                'department_id' => 4,
                'company_id' => 1,
            ),
            10 => 
            array (
                'user_id' => 12,
                'department_id' => 6,
                'company_id' => 2,
            ),
            11 => 
            array (
                'user_id' => 13,
                'department_id' => 2,
                'company_id' => 1,
            ),
            12 => 
            array (
                'user_id' => 14,
                'department_id' => 6,
                'company_id' => 2,
            ),
        ));
        
        
    }
}