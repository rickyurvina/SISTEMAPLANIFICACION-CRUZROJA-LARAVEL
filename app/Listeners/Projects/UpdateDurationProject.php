<?php

namespace App\Listeners\Projects;

use App\Events\Projects\ProjectUpdatedThresholds;
use App\Models\Projects\Project;
use Illuminate\Support\Facades\DB;

class UpdateDurationProject
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
            $project = Project::find($event->project->id);
            if ($project->start_date < $project->end_date) {
                $hours = $project->start_date->diffInHours($project->end_date);
                $project->duration = $hours;
                $project->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
