<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaActivityPiatRescheduling;
use Illuminate\Support\Facades\DB;

class PoaPiatActivityDeleteRescheduling extends Job
{
    protected $reschedule;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
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
            $this->reschedule=PoaActivityPiatRescheduling::find($this->request);
            $this->reschedule->delete();
            DB::commit();
            return $this->reschedule;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
