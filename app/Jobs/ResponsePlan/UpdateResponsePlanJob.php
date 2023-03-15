<?php

namespace App\Jobs\ResponsePlan;

use App\Abstracts\Job;
use App\Models\ResponsePlan\ResponsePlan;

class UpdateResponsePlanJob extends Job
{
    protected int $id;
    protected int $responsePlanResult;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $id
     * @param  $request
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
        $this->responsePlanResult = ResponsePlan::where('id', $this->id)->update($this->request->all());
        return $this->responsePlanResult;
    }
}
