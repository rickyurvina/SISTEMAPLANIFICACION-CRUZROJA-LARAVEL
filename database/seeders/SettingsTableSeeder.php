<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

//        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            11 => 
            array (
                'id' => 12,
                'company_id' => 2,
                'key' => 'localisation.timezone',
                'value' => 'UTC',
            ),
            12 => 
            array (
                'id' => 13,
                'company_id' => 2,
                'key' => 'localisation.date_format',
                'value' => 'd M Y',
            ),
            13 => 
            array (
                'id' => 14,
                'company_id' => 2,
                'key' => 'localisation.date_separator',
                'value' => 'space',
            ),
            14 => 
            array (
                'id' => 15,
                'company_id' => 2,
                'key' => 'localisation.percent_position',
                'value' => 'after',
            ),
            15 => 
            array (
                'id' => 16,
                'company_id' => 2,
                'key' => 'default.list_limit',
                'value' => '25',
            ),
            16 => 
            array (
                'id' => 17,
                'company_id' => 2,
                'key' => 'default.currency',
                'value' => 'USD',
            ),
            17 => 
            array (
                'id' => 18,
                'company_id' => 2,
                'key' => 'default.locale',
                'value' => 'es_ES',
            ),
            18 => 
            array (
                'id' => 19,
                'company_id' => 2,
                'key' => 'company.name',
                'value' => 'GUAYAS',
            ),
            19 => 
            array (
                'id' => 20,
                'company_id' => 2,
                'key' => 'company.identification',
                'value' => '1721351441001',
            ),
            20 => 
            array (
                'id' => 21,
                'company_id' => 3,
                'key' => 'localisation.timezone',
                'value' => 'UTC',
            ),
            21 => 
            array (
                'id' => 22,
                'company_id' => 3,
                'key' => 'localisation.date_format',
                'value' => 'd M Y',
            ),
            22 => 
            array (
                'id' => 23,
                'company_id' => 3,
                'key' => 'localisation.date_separator',
                'value' => 'space',
            ),
            23 => 
            array (
                'id' => 24,
                'company_id' => 3,
                'key' => 'localisation.percent_position',
                'value' => 'after',
            ),
            24 => 
            array (
                'id' => 25,
                'company_id' => 3,
                'key' => 'default.list_limit',
                'value' => '25',
            ),
            25 => 
            array (
                'id' => 26,
                'company_id' => 3,
                'key' => 'default.currency',
                'value' => 'USD',
            ),
            26 => 
            array (
                'id' => 27,
                'company_id' => 3,
                'key' => 'default.locale',
                'value' => 'es_ES',
            ),
            27 => 
            array (
                'id' => 28,
                'company_id' => 3,
                'key' => 'company.name',
                'value' => 'Guayaquil',
            ),
            28 => 
            array (
                'id' => 29,
                'company_id' => 3,
                'key' => 'company.identification',
                'value' => '1721351441001',
            ),
        ));
        
        
    }
}