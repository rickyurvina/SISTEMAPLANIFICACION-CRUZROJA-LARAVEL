<?php

namespace App\Listeners\Projects\Activities;

use App\Events\Projects\Activities\TaskUpdatedThresholds;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateFieldsThresholdTask
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
     * @param \App\Events\Projects\Activities\TaskUpdatedThresholds $event
     * @return void
     */
    public function handle(TaskUpdatedThresholds $event)
    {
        try {
            DB::beginTransaction();
            $task = $event->task;
            $threshold = $task->threshold->first();
            $threshold->start_date = $task->start_date;
            $threshold->end_date = $task->end_date;
            $threshold->progress_physic = $task->progress;
            $threshold->save();
            DB::commit();
            return $threshold;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
        
    }
}
