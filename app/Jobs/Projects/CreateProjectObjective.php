<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Objectives\ProjectObjectives;


class CreateProjectObjective extends Job
{
    protected $projectObjective;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request = $this->getRequestInstance($request);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $objectiveId = $this->request->id;
        if ($objectiveId) {
            $objective = ProjectObjectives::find($objectiveId);
            $this->projectObjective = $objective->update($this->request->all());
        } else {
            $this->projectObjective = ProjectObjectives::create($this->request->all());
        }
    }
}
