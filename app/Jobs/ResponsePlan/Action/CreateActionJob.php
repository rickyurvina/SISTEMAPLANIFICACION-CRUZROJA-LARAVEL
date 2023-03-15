<?php

namespace App\Jobs\ResponsePlan\Action;

use App\Abstracts\Job;
use App\Models\ResponsePlan\Action;

class CreateActionJob extends Job
{

    protected $request;
    protected Action $action;

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
     * @return Action
     */
    public function handle(): Action
    {
        $this->action = Action::create($this->request->all());
        return $this->action;
    }
}
