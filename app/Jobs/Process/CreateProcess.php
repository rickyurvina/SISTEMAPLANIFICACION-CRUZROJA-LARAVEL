<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\NonConformities;
use App\Models\Process\Process;
use Illuminate\Support\Facades\DB;

class CreateProcess extends Job
{
    protected $request;
    protected $process;

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
     * @return Process
     */
    public function handle(): Process
    {
        try {
            DB::beginTransaction();
            $this->process = Process::create($this->request->all());
            DB::commit();
            return $this->process;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}