<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\PlanDetail;

class DeletePlanDetail extends Job
{
    protected PlanDetail $planDetail;

    /**
     * Create a new job instance.
     *
     * @param $planDetail
     */
    public function __construct($planDetail)
    {
        $this->planDetail = $planDetail;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        PlanDetail::destroy($this->planDetail->id);
        return true;
    }
}
