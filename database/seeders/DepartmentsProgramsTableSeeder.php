<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsProgramsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments_programs')->delete();
        
        \DB::table('departments_programs')->insert(array (
            0 => 
            array (
                'department_id' => 1,
                'program_id' => 15,
            ),
            1 => 
            array (
                'department_id' => 2,
                'program_id' => 16,
            ),
            2 => 
            array (
                'department_id' => 4,
                'program_id' => 19,
            ),
            3 => 
            array (
                'department_id' => 6,
                'program_id' => 32,
            ),
        ));
        
        
    }
}