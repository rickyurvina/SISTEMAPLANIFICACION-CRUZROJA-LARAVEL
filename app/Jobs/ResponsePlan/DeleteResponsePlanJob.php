<?php

namespace App\Jobs\ResponsePlan;

use App\Abstracts\Job;
use App\Models\ResponsePlan\ResponsePlan;

class DeleteResponsePlanJob extends Job
{

    protected ResponsePlan $response_plan;

    /**
     * Create a new job instance.
     *
     * @param $response_plan
     */
    public function __construct($response_plan)
    {
        $this->response_plan = $response_plan;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        ResponsePlan::destroy($this->response_plan->id);
        return true;
    }
}