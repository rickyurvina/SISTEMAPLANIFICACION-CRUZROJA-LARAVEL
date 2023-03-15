<?php

namespace App\Listeners\MeasureAdvances;

use App\Events\Poa\PoaActivityDeleted;
use Illuminate\Support\Facades\DB;

class DeleteMeasureAdvances
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
     * @param \App\Events\Poa\PoaActivityDeleted $event
     * @return void
     */
    public function handle(PoaActivityDeleted $event)
    {
        //
        $model = $event->poaActivity;
        try {
            DB::beginTransaction();
            $model->measureAdvances->each->forceDelete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
