<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Auth\Role;
use App\Models\Projects\Project;
use DB;
use Throwable;

class UpdateProject extends Job
{
    protected $project;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $project
     * @param  $request
     */
    public function __construct($project, $request)
    {
        $this->project = $project;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Project
     * @throws Throwable
     */
    public function handle(): Project
    {
        DB::transaction(function () {
            $this->project->update($this->request->all());
        });

        return $this->project;
    }
}
