<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\Plan;

class DeletePlan extends Job
{
    protected $planId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Plan::destroy($this->planId);
    }
}
