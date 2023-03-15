<?php

namespace Database\Seeders;

use App\Models\Indicators\Units\IndicatorUnits;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateIndicatorUnitsForPeople extends Seeder
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
            DB::beginTransaction();
            IndicatorUnits::whereIn('abbreviation', [IndicatorUnits::PEOPLE_REACHED, IndicatorUnits::TRAINED_PEOPLE])
                ->update(
                    [
                        'is_for_people' => true
                    ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

    }
}
