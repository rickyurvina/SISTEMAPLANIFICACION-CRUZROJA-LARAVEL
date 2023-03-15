<?php

namespace App\Jobs\ResponsePlan\Action;

use App\Abstracts\Job;
use App\Models\ResponsePlan\Action;

class UpdateActionJob extends Job
{
    protected int $id;
    protected int $actionResult;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $request
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->actionResult = Action::where('id', $this->id)->update($this->request->all());
        return $this->actionResult;
    }
}
