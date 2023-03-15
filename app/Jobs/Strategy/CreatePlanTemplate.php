<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Http\FormRequest;
use App\Abstracts\Job;
use App\Models\Strategy\PlanTemplate;

class CreatePlanTemplate extends Job
{

    protected $planTemplate;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param FormRequest $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return PlanTemplate
     */
    public function handle(): PlanTemplate
    {
        $this->planTemplate = PlanTemplate::create($this->request->all());

        return $this->planTemplate;
    }
}
