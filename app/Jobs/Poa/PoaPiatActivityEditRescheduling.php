<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaActivityPiatRescheduling;
use Illuminate\Support\Facades\DB;

class PoaPiatActivityEditRescheduling extends Job
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
        $this->request=$this->getRequestInstance($request);
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
            $this->rescheduling=PoaActivityPiatRescheduling::find($this->request->id);
            $this->rescheduling=$this->rescheduling->update($this->request->all());
            DB::commit();
            return $this->rescheduling;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
