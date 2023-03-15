<?php

namespace App\Jobs\Poa;


use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaActivityPiat;

class UpdatePoaActivityPiat extends Job
{
    protected int $piatResult;
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
        $this->piatResult = PoaActivityPiat::where('id', $this->id)
            ->update($this->request->all());

        return $this->piatResult;
    }
}
