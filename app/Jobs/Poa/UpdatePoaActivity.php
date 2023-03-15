<?php

namespace App\Jobs\Poa;


use App\Abstracts\Job;
use App\Models\Poa\PoaActivity;

class UpdatePoaActivity extends Job
{
    protected int $poaActivityResult;
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
        $this->poaActivityResult = PoaActivity::where('id', $this->id)
            ->update($this->request->all());

        return $this->poaActivityResult;
    }
}
