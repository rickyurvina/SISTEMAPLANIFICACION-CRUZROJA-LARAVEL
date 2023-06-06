<?php

namespace App\Listeners\Measure;

use App\Events\Measure\MeasureAdvanceUpdated;
use App\Jobs\Indicators\Sources\UpdateSource;
use App\Jobs\Strategy\UpdateScoresStrategy;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Measure\Score;
use App\Models\Strategy\Plan;
use App\Scopes\Company;
use App\Traits\Jobs;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UpdateScore
{
    use Jobs;

    protected $periods;

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
        try {
//            DB::beginTransaction();
            $year = date('Y'); //
            $this->periods = Period::whereYear('start_date', $year)
                ->whereYear('end_date', $year)
                ->get();
            self::updateScoreOfMeasures();
            self::updateScoreOfPlanDetails();
//            DB::commit();
        } catch (\Exception $exception) {
//            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function updateScoreOfMeasures()
    {
        $measureAdvances = MeasureAdvances::whereIn('period_id', $this->periods->pluck('id')->toArray())
            ->get()->groupBy('measure_id');

        foreach ($measureAdvances as $measureId => $measureAdvance) {
            $measureAdvanceGroupByPeriod = $measureAdvance->groupBy('period_id');
            foreach ($measureAdvanceGroupByPeriod as $periodId => $item) {
                $measureGroupByTypeOfAggregation = $item->groupBy('aggregation_type');
                $sumActual = 0;
                foreach ($measureGroupByTypeOfAggregation as $type => $aggregation) {
                    if ($type == Measure::AGGREGATION_TYPE_SUM) {
                        $sumActual += $aggregation->sum('actual');
                    } elseif ($type == Measure::AGGREGATION_TYPE_AVE) {
                        $sumActual += $aggregation->avg('actual');
                    }
                }
                $score = Score::where([
                    ['scoreable_type', '=', Measure::class],
                    ['period_id', '=', $periodId],
                    ['scoreable_id', '=', $measureId]
                ])->first();
                $score->actual = $sumActual;
                $score->save();
            }
        }
    }

    /**
     * @return void
     */
    public function updateScoreOfPlanDetails()
    {
        $plan = Plan::active()->type(Plan::TYPE_STRATEGY)->first();
        foreach ($this->periods as $period) {
            $plan->updateScore($period);
            $children = $plan->children()->get();
            if ($children->count()) {
                self::updateScoreChildren($children, $period);
            }
        }
    }

    /**
     * @param $children
     * @param $period
     * @return void
     */
    public function updateScoreChildren($children, $period)
    {
        foreach ($children as $element) {
            $element->updateScore($period);
            if ($element->children->count()) {
                self::updateScoreChildren($element->children()->get(), $period);
            }
        }
    }
}
