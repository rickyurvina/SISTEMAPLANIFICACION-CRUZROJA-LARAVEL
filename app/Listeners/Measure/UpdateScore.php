<?php

namespace App\Listeners\Measure;

use App\Events\Measure\MeasureAdvanceUpdated;
use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Score;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UpdateScore
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\Measure\MeasureAdvanceUpdated $event
     * @return void
     */
    public function handle(MeasureAdvanceUpdated $event)
    {
        //
        $measureAdvance = $event->measureAdvamce;
        try {
            DB::beginTransaction();
            $periodId = $measureAdvance->period_id;
            $model = App::make($measureAdvance->measurable_type)->find($measureAdvance->measurable_id);
            $measure = Measure::withoutGlobalScopes()->find($model->measure_id);
            $measureAdvances = MeasureAdvances::where('period_id', $periodId)
                ->where('measurable_type', $model::class)
                ->where('measurable_id', $model->id);
            $score = Score::where([
                ['scoreable_type', '=', Measure::class],
                ['period_id', '=', $periodId],
                ['scoreable_id', '=', $measure->id]
            ])->first();
            $oldActual = $score->actual;
            $valueToSubtract = $measureAdvance->getOriginal('actual');
            if ($measureAdvance->aggregation_type == MeasureAdvances::AGGREGATION_TYPE_SUM) {
                $actual = $measureAdvance->actual;
            } else {
                $actual = $measureAdvances->actual / $measureAdvances->count();
            }
            $newActual = $oldActual + $actual - $valueToSubtract;
            $score->actual = $newActual;
            $score->save();
            DB::commit();
            return $measureAdvance;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
