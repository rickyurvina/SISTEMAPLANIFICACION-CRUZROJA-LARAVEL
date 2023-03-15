<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\ChangesActivities;
use Illuminate\Support\Facades\DB;

class CreateChangeActivity extends Job
{
    public $request;
    public $activity;
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
            $this->activity = ChangesActivities::create($this->request->all());
            DB::commit();
            return $this->activity;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
