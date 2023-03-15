<?php

namespace App\Listeners\Projects;

use App\Events\Projects\ProjectCreated;
use App\Models\Projects\ProjectMemberSubsidiary;
use function session;

class CreateProjectMemberSubsidiary
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
     * @param \App\Events\Projects\ProjectCreated $event
     * @return void
     */
    public function handle(ProjectCreated $event)
    {
        //
        $project = $event->project;
        $projectMemberSubsidiary = new ProjectMemberSubsidiary();
        $projectMemberSubsidiary->project_id = $project->id;
        $projectMemberSubsidiary->company_id = session('company_id');
        $projectMemberSubsidiary->save();
    }
}
