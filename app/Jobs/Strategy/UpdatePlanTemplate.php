<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\PlanTemplate;

class UpdatePlanTemplate extends Job
{
    protected int $planTemplateResult;
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
     * @return mixed
     */
    public function handle(): int
    {
        $this->planTemplateResult = PlanTemplate::where('id', $this->id)
            ->update($this->request->all());

        return $this->planTemplateResult;
    }
}
