<?php

namespace Database\Seeders;

use App\Jobs\Strategy\UpdateScoresStrategy;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class UpdateScoresStrategyWithJob extends Seeder
{
    use Jobs;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $this->ajaxDispatch(new UpdateScoresStrategy());
    }
}
