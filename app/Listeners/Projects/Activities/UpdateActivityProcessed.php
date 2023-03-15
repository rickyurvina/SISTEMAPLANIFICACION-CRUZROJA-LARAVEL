<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\ActivityProcessed;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;

class UpdateActivityProcessed
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
     * @param ActivityProcessed $event
     *
     * @return void
     */
    public function handle(ActivityProcessed $event)//TODO VERIFICAR FUNCIONAMIENTO
    {
        $poaActivities = PoaActivity::where('measure_id', $event->activity)->get();
        $measure = MeasureAdvances::where('measurable_type', PoaActivity::class)
            ->whereIn('measurable_id', $poaActivities->pluck('id'));
        $measure->goal = $poaActivities->sum('goal');
        $measure->actual = $poaActivities->sum('actual');
        $measure->save();
    }
}
