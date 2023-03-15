<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;

class PoaPiatActivityCreateRescheduling extends Job
{

    protected $rescheduling;
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
     */
    public function handle()
    {
        //
        try {
            DB::beginTransaction();
            $this->rescheduling = \App\Models\Poa\Piat\PoaActivityPiatRescheduling::create($this->request->all());
            DB::commit();
            return $this->rescheduling;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
