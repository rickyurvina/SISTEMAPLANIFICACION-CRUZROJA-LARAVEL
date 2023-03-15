<?php

namespace App\Jobs\Process;


use App\Abstracts\Job;
use App\Models\Process\NonConformities;

class DeleteNonConformity extends Job
{
    public NonConformities $non_conformity;

    public function __construct(NonConformities $non_conformity)
    {
        $this->non_conformity = $non_conformity;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $response=NonConformities::destroy($this->non_conformity->id);
        return $response;
    }
}
