<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

//        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            2 => 
            array (
                'id' => 3,
                'name' => 'Coordinador Local de Proyecto',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 20:42:48',
                'updated_at' => '2022-01-25 20:42:48',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Coordinador de Proyecto',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 20:44:12',
                'updated_at' => '2022-01-25 20:44:12',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Técnico Administrativo',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 20:51:23',
                'updated_at' => '2022-01-25 20:51:23',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Oficial De Presupuestos Local',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 20:52:46',
                'updated_at' => '2022-01-25 20:52:46',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Técnico Operativo',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 23:22:44',
                'updated_at' => '2022-01-25 23:22:44',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Oficial De Pmer',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 23:24:31',
                'updated_at' => '2022-01-25 23:24:31',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Técnico Especialista',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 23:25:35',
                'updated_at' => '2022-01-25 23:25:35',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Oficial De Presupuestos',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 23:28:27',
                'updated_at' => '2022-01-25 23:28:27',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Oficial De Pmer Local',
                'guard_name' => 'web',
                'created_at' => '2022-01-25 23:29:09',
                'updated_at' => '2022-01-25 23:29:09',
            ),
        ));
        
        
    }
}