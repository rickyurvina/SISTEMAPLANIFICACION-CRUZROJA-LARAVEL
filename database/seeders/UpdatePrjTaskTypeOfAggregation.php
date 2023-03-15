<?php

namespace Database\Seeders;

use App\Models\Projects\Activities\Task;
use Illuminate\Database\Seeder;

class UpdatePrjTaskTypeOfAggregation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try {
            Task::where('aggregation_type', null)->update([
                'aggregation_type' => 'sum'
            ]);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
