<?php

namespace App\Listeners\Measure;

use App\Events\Measure\ScoreUpdated;
use App\Models\Measure\Measure;
use App\Models\Measure\Score;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use Illuminate\Support\Facades\DB;

class UpdateMeasureScore
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
     * @param ScoreUpdated $event
     *
     */
    public function handle(ScoreUpdated $event)
    {
        try {
            DB::beginTransaction();
            $score = $event->score;
            $model = $score->scoreable;
            if ($model::class == Measure::class) {
                $parent = $model->indicatorable;;
                if ($parent::class == PlanDetail::class) {
                    $measuresOfParent = Measure::where('indicatorable_type', PlanDetail::class)
                        ->where('indicatorable_id', $parent->id)->get();
                    $scoresOfMeasures = Score::where('scoreable_type', Measure::class)
                        ->whereIn('scoreable_id', $measuresOfParent->pluck('id')->toArray())
                        ->wherePeriodId($score->period_id)
                        ->get();
                    $sumWeight = 0;
                    $sumScore = 0;
                    foreach ($scoresOfMeasures as $sc) {
                        $sumScore += $sc->score * $sc->scoreable->weight;
                        $sumWeight += $sc->scoreable->weight;
                    }
                    if ($sumWeight) {
                        $scoreForParent = $sumScore / $sumWeight;
                        $scoreOfParent = Score::where('scoreable_type', $parent::class)
                            ->where('scoreable_id', $parent->id)
                            ->wherePeriodId($score->period_id)->first();
                        $data =
                            [
                                'score' => round($scoreForParent, 1),
                                'color' => $scoreOfParent->colorByScore($scoreForParent),
                            ];
                        $scoreOfParent->update($data);
                    }
                }
            }
            if ($model::class == PlanDetail::class) {
                $siblings = $model->siblingsAndSelf();
                $scoresOfMeasures = Score::where('scoreable_type', PlanDetail::class)
                    ->whereIn('scoreable_id', $siblings->pluck('id')->toArray())
                    ->wherePeriodId($score->period_id)
                    ->get();
                $sumWeight = 0;
                $sumScore = 0;
                foreach ($scoresOfMeasures as $sc) {
                    $sumScore += $sc->score * $sc->scoreable->weight;
                    $sumWeight += $sc->scoreable->weight;
                }
                if ($sumWeight) {
                    $scoreForParent = $sumScore / $sumWeight;
                    if ($model->parent){
                        $scoreOfParent = Score::where('scoreable_type', $model::class)
                            ->where('scoreable_id', $model->parent_id)
                            ->wherePeriodId($score->period_id)->first();
                        if ($scoreOfParent) {
                            $data =
                                [
                                    'score' => round($scoreForParent, 1),
                                    'color' => $scoreOfParent->colorByScore($scoreForParent),
                                ];
                            $scoreOfParent->update($data);
                        }
                    }else{
                        $scoreOfParent = Score::where('scoreable_type', Plan::class)
                            ->where('scoreable_id', $model->plan_id)
                            ->wherePeriodId($score->period_id)->first();
                        if ($scoreOfParent) {
                            $data =
                                [
                                    'score' => round($scoreForParent, 1),
                                    'color' => $scoreOfParent->colorByScore($scoreForParent),
                                ];
                            $scoreOfParent->update($data);
                        }
                    }

                }
            }
            $scoreParents = Score::where([
                ['msr_scores.scoreable_type', '=', Measure::class],
                ['msr_scores.scoreable_id', '=', $model->id],
            ])->whereIn('msr_scores.period_id', function ($query) use ($model, $score) {
                $query->selectRaw('msr_period_children.parent_id')->from('msr_scores')->where([
                    ['msr_scores.scoreable_type', '=', Measure::class],
                    ['msr_scores.scoreable_id', '=', $model->id],
                    ['msr_scores.period_id', '=', $score->period->id]
                ])->join('msr_period_children', 'msr_scores.period_id', '=', 'msr_period_children.period_id');
            })->get();
            foreach ($scoreParents as $scoreParent) {
                $scoreChildren = Score::where([
                    ['scoreable_type', '=', Measure::class],
                    ['scoreable_id', '=', $model->id]
                ])->whereIn('period_id', function ($query) use ($scoreParent) {
                    $query->selectRaw('id')->from('msr_period_children')->where('parent_id', $scoreParent->period_id);
                })->get();

                $actual = null;
                $thresholds = $scoreChildren->pluck('thresholds')->toArray();
                $final = array_shift($thresholds);
                switch ($model->aggregation_type) {
                    case Measure::AGGREGATION_TYPE_SUM:
                        foreach ($final as $key => &$value) {
                            $value += array_sum(array_column($thresholds, $key));
                        }
                        unset($value);
                        $actual = $scoreChildren->sum('actual');
                        break;
                    case Measure::AGGREGATION_TYPE_AVE:
                        foreach ($final as $key => &$value) {
                            $value = array_sum(array_column($thresholds, $key)) / count($thresholds);
                        }
                        unset($value);
                        $actual = $scoreChildren->avg('actual');
                        break;
                    case Measure::AGGREGATION_TYPE_NUMBER_OF_YESES:
                        $actual = $scoreChildren->where('actual', 1)->sum('actual');

                }
                $scoreParent->actual = $actual;
                $scoreParent->thresholds = $final;
                $scoreParent->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

    }
}
