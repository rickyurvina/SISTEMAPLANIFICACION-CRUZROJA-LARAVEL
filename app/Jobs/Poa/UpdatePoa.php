<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Poa;

class UpdatePoa extends Job
{
    protected int $poaResult;
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
        $this->poaResult = Poa::where('id', $this->id)
            ->update($this->request->all());

        return $this->poaResult;
    }
}
