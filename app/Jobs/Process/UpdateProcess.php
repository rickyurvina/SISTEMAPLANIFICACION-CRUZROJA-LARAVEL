<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Process;

class UpdateProcess extends Job
{
    protected $request;
    protected Process $process;

    /**
     * Create a new job instance.
     * @param $request
     * @param $process
     * @return void
     */
    public function __construct($request, $process)
    {
        $this->process = $process;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Process
     */
    public function handle(): Process
    {
        $this->process->update($this->request->all());
        return $this->process;
    }
}
