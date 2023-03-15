<?php

namespace App\Listeners\Projects;

use App\Events\Projects\ProjectUpdatedThresholds;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateFieldsThresholdProject
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
     * @param \App\Events\Projects\ProjectUpdatedThresholds $event
     * @return void
     */
    public function handle(ProjectUpdatedThresholds $event)
    {
        try {
            DB::beginTransaction();
            $project = $event->project;
            $threshold = $project->threshold->first();
            $threshold->start_date = $project->start_date;
            $threshold->end_date = $project->end_date;
            $threshold->progress_physic = $project->tasks->where('parent', 'root')->first()->progress;
            $threshold->save();
            DB::commit();
            return $threshold;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
