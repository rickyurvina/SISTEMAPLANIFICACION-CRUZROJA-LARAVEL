<?php

namespace Database\Seeders;

use App\Models\Indicators\Units\IndicatorUnits;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndicatorUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        IndicatorUnits::factory()->times(10)->create();
        DB::table('indicator_units')->insert([
            'name'=>'Personas Alcanzadas',
            'abbreviation'=>'PA'
        ]);
        DB::table('indicator_units')->insert([
            'name'=>'Personas Capacitadas',
            'abbreviation'=>'PCap'
        ]);
        DB::table('indicator_units')->insert([
            'name'=>'Documentos',
            'abbreviation'=>'Doc'
        ]);
        DB::table('indicator_units')->insert([
            'name'=>'Evaluación',
            'abbreviation'=>'Eva'
        ]);
    }
}
