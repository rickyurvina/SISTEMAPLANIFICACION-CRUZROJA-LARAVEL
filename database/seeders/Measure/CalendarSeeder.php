<?php

namespace Database\Seeders\Measure;

use DB;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('msr_calendars')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Mensual',
                    'type' => 'standard',
                    'frequency' => 'monthly',
                    'start_date' => '2021-01-01',
                    'end_date' => '2025-12-31',
                ],
                [
                    'id' => 2,
                    'name' => 'Trimensual',
                    'type' => 'standard',
                    'frequency' => 'quarterly',
                    'start_date' => '2021-01-01',
                    'end_date' => '2025-12-31',
                ],
                [
                    'id' => 3,
                    'name' => 'Semestral',
                    'type' => 'standard',
                    'frequency' => 'semester',
                    'start_date' => '2021-01-01',
                    'end_date' => '2025-12-31',
                ],
                [
                    'id' => 4,
                    'name' => 'Anual',
                    'type' => 'standard',
                    'frequency' => 'yearly',
                    'start_date' => '2021-01-01',
                    'end_date' => '2025-12-31',
                ],
            ]);
    }
}