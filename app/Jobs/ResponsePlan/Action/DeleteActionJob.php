<?php

namespace App\Jobs\ResponsePlan\Action;

use App\Abstracts\Job;
use App\Models\ResponsePlan\Action;

class DeleteActionJob extends Job
{
    protected Action $action;

    /**
     * Create a new job instance.
     *
     * @param $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Action::destroy($this->action->id);
        return true;
    }
}
