<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\NonConformity;
use App\Models\Process\Process;

class UpdateNonConformity extends Job
{
    protected $request;
    protected NonConformity $non_conformity;
    /**
     * Create a new job instance.
     * @param $request
     * @param $non_conformity
     * @return void
     */
    public function __construct($request, $non_conformity)
    {
        $this->non_conformity = $non_conformity;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return NonConformity
     */
    public function handle(): NonConformity
    {
        $this->non_conformity->update($this->request->all());
        return $this->non_conformity;
    }
}
