<?php

namespace App\Listeners\Indicators;

use App\Events\Indicators\ActualValueIndicatorUpdated;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use Illuminate\Support\Facades\DB;

class UpdateAdvanceIndicator
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
     * @param \App\Events\Indicators\ActualValueIndicatorUpdated $event
     * @return void
     */
    public function handle(ActualValueIndicatorUpdated $event)
    {
        try {
            DB::beginTransaction();
            //
            $goal = $event->goal;
            $indicator = Indicator::find($goal->indicators_id);
            $actualValues = GoalIndicators::where('indicators_id', $indicator->id)->sum('actual_value');
            $goalValues = GoalIndicators::where('indicators_id', $indicator->id)->sum('goal_value');
            $indicator->total_goal_value = $goalValues;
            $indicator->total_actual_value = $actualValues;
            $indicator->save();
            DB::commit();
            return $goal;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
