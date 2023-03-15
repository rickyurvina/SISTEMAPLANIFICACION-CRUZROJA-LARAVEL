<?php

namespace App\Listeners\Poa;

use App\Events\Poa\PoaActivityIndicatorUpdated;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;

class UpdateActivity
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
     * @param \App\Events\Poa\PoaActivityIndicatorUpdated $event
     * @return void
     */
    public function handle(PoaActivityIndicatorUpdated $event)//TODO VERIFICAR SI SE USA ESTA FUNCION EN ALGUN LADO, ESTE EVENTO CON EL LISTENER
    {
        $model = $event->model;
        $activity = PoaActivity::find($model->poa_activity_id);
        $goals = MeasureAdvances::where('measurable_type', PoaActivity::class)
            ->where('measurable_id', $activity->id);
        $sumGoals = $goals->sum('goal');
        $sumProgress = $goals->sum('progress');
        $activity->goal = $sumGoals;
        $activity->progress = $sumProgress;
        $activity->save();
    }
}
