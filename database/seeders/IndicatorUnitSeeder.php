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
        DB::table('indicator_units')->insert([
            'name'=>'Personas Alcanzadas',
            'abbreviation'=>IndicatorUnits::PEOPLE_REACHED
        ]);
        DB::table('indicator_units')->insert([
            'name'=>'Personas Capacitadas',
            'abbreviation'=>IndicatorUnits::TRAINED_PEOPLE
        ]);
        DB::table('indicator_units')->insert([
            'name'=>'Documentos',
            'abbreviation'=>IndicatorUnits::DOCUMENTS
        ]);
        DB::table('indicator_units')->insert([
            'name'=>'Evaluación',
            'abbreviation'=>IndicatorUnits::EVALUATION
        ]);
    }
}
