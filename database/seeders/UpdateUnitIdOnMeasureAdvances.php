<?php

namespace Database\Seeders;

use App\Models\Measure\MeasureAdvances;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUnitIdOnMeasureAdvances extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            $measureAdvances_ = MeasureAdvances::with('measurable.measure')
                ->where('unit_id', null)->get();
            foreach ($measureAdvances_ as $measureAdvance_) {
                $model = $measureAdvance_->measurable;
                if ($model->measure()->first()) {
                    $unitId = $model->measure->unit_id;
                    $measureAdvance_->unit_id = $unitId;
                    $measureAdvance_->save();
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
