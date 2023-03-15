<?php

namespace App\Listeners\Measure;

use App\Events\Measure\MeasureGroupedCreated;
use App\Models\Measure\Measure;
use App\Models\Measure\Score;

class UpdateMeasureGrouped
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
     * @param MeasureGroupedCreated $event
     *
     * @return void
     */
    public function handle(MeasureGroupedCreated $event)
    {
        $measure = $event->measure;

        $measure->load(['scores', 'group']);

        $measure->scores->each(function ($score) use ($measure) {

            $scores = Score::where([
                ['msr_scores.scoreable_type', '=', Measure::class]
            ])->whereIn('msr_scores.scoreable_id', $measure->group->pluck('id'))
                ->where(function ($q) use ($score) {
                    $q->where('msr_scores.period_id', $score->period_id)->orWhereIn('msr_scores.period_id', function ($query) use ($score) {
                        $query->selectRaw('id')->from('msr_period_children')->where('parent_id', $score->period_id);
                    });
                })->get();

            $actual = null;
            $existAnyValue = $scores->contains(function ($value) {
                return !is_null($value->actual);
            });
            if ($existAnyValue) {
                switch ($measure->aggregation_type) {
                    case Measure::AGGREGATION_TYPE_SUM:
                        $actual = $scores->sum('actual');
                        break;
                    case Measure::AGGREGATION_TYPE_AVE:
                        $actual = $scores->avg('actual');
                        break;
                    case Measure::AGGREGATION_TYPE_NUMBER_OF_YESES:
                        $actual = $scores->where('actual', 1)->sum('actual');
                }
                $score->actual = $actual;
                $score->save();
            }
        });
    }
}
