<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Activity;
use App\Models\Process\Process;

class UpdateActivity extends Job
{
    protected $request;
    protected Activity $activity;

    /**
     * Create a new job instance.
     *
     * @param $request
     * @param $activity
     * @return void
     */
    public function __construct($request, $activity)
    {
        $this->activity = $activity;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Process
     */
    public function handle()
    {
        $this->activity->update($this->request->all());
        return $this->activity;
    }
}
