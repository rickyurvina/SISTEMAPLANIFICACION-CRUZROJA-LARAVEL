<?php

namespace App\Jobs\ResponsePlan;

use App\Abstracts\Job;
use App\Models\ResponsePlan\ResponsePlan;

class CreateResponsePlanJob extends Job
{
    protected $request;
    protected ResponsePlan $response_plan;

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
     *
     * @return ResponsePlan
     */
    public function handle(): ResponsePlan
    {
        $this->response_plan = ResponsePlan::create($this->request->all());
        return $this->response_plan;
    }
}