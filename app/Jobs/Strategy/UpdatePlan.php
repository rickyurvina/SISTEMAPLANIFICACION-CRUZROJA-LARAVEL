<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\Plan;

class UpdatePlan extends Job
{
    protected int $planResult;
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
    public function handle() : int
    {
        $this->planResult = Plan::where('id', $this->id)
            ->update($this->request->all());

        return $this->planResult;
    }
}
