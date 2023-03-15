<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\PoaProgram;
use Exception;

class CreatePoaProgram extends Job
{
    protected $poaProgram;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        try {
            $this->poaProgram = PoaProgram::create($this->request->all());
            return $this->poaProgram;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
