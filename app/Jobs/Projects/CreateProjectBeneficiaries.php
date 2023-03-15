<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\ProjectBeneficiaries;

class CreateProjectBeneficiaries extends Job
{

    protected $request;
    protected ProjectBeneficiaries $projectBeneficiaries;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return ProjectBeneficiaries
     */
    public function handle(): ProjectBeneficiaries
    {
        $this->projectBeneficiaries = ProjectBeneficiaries::create($this->request->all());
        return $this->projectBeneficiaries;
    }
}