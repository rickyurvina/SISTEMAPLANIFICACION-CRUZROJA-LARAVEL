<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\PoaActivityTemplate;

class CreatePoaActivityTemplate extends Job
{

    protected $request;
    protected PoaActivityTemplate $poaActivityTemplate;

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
     * @return PoaActivityTemplate
     */
    public function handle(): PoaActivityTemplate
    {
        $this->poaActivityTemplate = PoaActivityTemplate::create($this->request->all());
        return $this->poaActivityTemplate;
    }
}