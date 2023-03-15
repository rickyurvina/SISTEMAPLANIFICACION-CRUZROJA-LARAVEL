<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Activity;
use Illuminate\Support\Facades\DB;

class CreateActivity extends Job
{
    public $request;
    public $activity;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Activity
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->activity = Activity::create($this->request->all());
            DB::commit();
            return $this->activity;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
