<?php

namespace App\Listeners\Indicators;

use App\Events\Indicators\IndicatorUpdated;
use App\Models\Indicators\Indicator\Indicator;
use Illuminate\Support\Facades\DB;

class UpdateIndicatorParents
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
     * @param \App\Events\Indicators\IndicatorUpdated $event
     * @return void
     */
    public function handle(IndicatorUpdated $event)
    {
        //
        try {
            DB::beginTransaction();
            $indicator = $event->indicator;
            $indicatorParents = $indicator->indicatorChild->pluck('parent_indicator')->toArray();
            $indicatorsToBeUpdated = Indicator::whereIn('id', $indicatorParents)->get();
            foreach ($indicatorsToBeUpdated as $item) {
                $childs = $item->indicatorParents->pluck('indicator');
                $item->total_goal_value = $childs->sum('total_goal_value');
                $item->total_actual_value = $childs->sum('total_actual_value');
                $item->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw  new \Exception($exception->getMessage());
        }

    }
}
