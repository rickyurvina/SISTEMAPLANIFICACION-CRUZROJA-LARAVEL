<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\ProcessPlanChanges;
use Illuminate\Support\Facades\DB;

class CreatePlanChange extends Job
{
    public $request;
    public $planChange;

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
        try {
            DB::beginTransaction();
            $this->planChange = ProcessPlanChanges::create($this->request->all());
            DB::commit();
            return $this->planChange;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
