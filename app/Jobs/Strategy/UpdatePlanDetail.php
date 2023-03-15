<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\PlanDetail;

class UpdatePlanDetail extends Job
{
    protected int $planDetailResult;
    protected $id;
    protected $request;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->planDetailResult = PlanDetail::where('id', $this->id)
            ->update($this->request->all());

        return $this->planDetailResult;
    }
}
