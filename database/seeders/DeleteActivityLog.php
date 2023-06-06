<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeleteActivityLog extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('activity_log')->delete();

    }
}
