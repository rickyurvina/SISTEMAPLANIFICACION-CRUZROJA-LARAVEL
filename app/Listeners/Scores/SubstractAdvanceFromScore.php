<?php

namespace App\Listeners\Scores;

use App\Events\MeasureAdvance\MeasureAdvanceDeleted;
use App\Models\Measure\Measure;
use App\Models\Measure\Score;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class SubstractAdvanceFromScore
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
     * @param \App\Events\MeasureAdvance\MeasureAdvanceDeleted $event
     * @return void
     */
    public function handle(MeasureAdvanceDeleted $event)
    {
        //
        try {
            DB::beginTransaction();
            $measureAdvance = $event->measureAdvance;
            $periodId = $measureAdvance->period_id;
            $model = App::make($measureAdvance->measurable_type)->find($measureAdvance->measurable_id);
            $measure = Measure::withoutGlobalScopes()->find($model->measure_id);
            $score = Score::where([
                ['scoreable_type', '=', Measure::class],
                ['period_id', '=', $periodId],
                ['scoreable_id', '=', $measure->id]
            ])->first();
            $oldActual = $score->actual;
            $valueToSubtract = $measureAdvance->actual;
            $newActual = $oldActual - $valueToSubtract;
            $score->actual = $newActual;
            $score->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }


    }
}
