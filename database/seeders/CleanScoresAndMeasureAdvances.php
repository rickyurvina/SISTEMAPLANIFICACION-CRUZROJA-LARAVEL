<?php

namespace Database\Seeders;

use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Score;
use Illuminate\Database\Seeder;

class CleanScoresAndMeasureAdvances extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Score::where('score', '!=', null)
            ->update(
                [
                    'score' => null,
                    'color' => 'gray',
                    'actual' => null,
                ]);
        MeasureAdvances::where('actual', '!=', null)
            ->update([
                'actual' => null,
                'men' => null,
                'women' => null,
            ]);
    }
}
