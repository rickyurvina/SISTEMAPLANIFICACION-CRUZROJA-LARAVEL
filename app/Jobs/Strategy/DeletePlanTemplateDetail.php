<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\PlanTemplateDetails;

class DeletePlanTemplateDetail extends Job
{
    protected $planTemplateDetail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($planTemplateDetail)
    {
        $this->planTemplateDetail = $planTemplateDetail;
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle(): int
    {
        return PlanTemplateDetails::destroy($this->planTemplateDetail);
    }
}
