<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\ProcessPlanChanges;
use Illuminate\Support\Facades\DB;

class DeletePlanChange extends Job
{

    public ProcessPlanChanges $planChanges;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProcessPlanChanges $planChanges)
    {
        $this->planChanges = $planChanges;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->planChanges->delete();
            DB::commit();
            return $this->planChanges;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }
    }
}
