<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\PlanDetail;

class CreatePlanDetail extends Job
{
    protected $planDetail;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->planDetail = PlanDetail::create($this->request->all());
        return $this->planDetail;
    }
}
