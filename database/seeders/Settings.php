<?php

namespace Database\Seeders;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        setting()->setExtraColumns(['company_id' => $company_id]);

        setting()->set([
            'localisation.timezone'             => 'UTC',
            'localisation.date_format'          => 'd M Y',
            'localisation.date_separator'       => 'space',
            'localisation.percent_position'     => 'after',
            'default.list_limit'                => '25'
        ]);
    }
}
