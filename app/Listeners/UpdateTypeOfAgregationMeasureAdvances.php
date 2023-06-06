<?php

namespace App\Listeners;

use App\Events\PoaActivityUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTypeOfAgregationMeasureAdvances
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
     * @param \App\Events\PoaActivityUpdated $event
     * @return void
     */
    public function handle(PoaActivityUpdated $event)
    {
        //
        try {
            \DB::beginTransaction();
            $poaActivity = $event->poaActivity;
            $measureAdvances = $poaActivity->measureAdvances;
            $measureAdvances->each->update(['aggregation_type' => $poaActivity->aggregation_type]);
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

    }
}
