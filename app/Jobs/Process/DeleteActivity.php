<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Activity;
use Illuminate\Support\Facades\DB;

class DeleteActivity extends Job
{
    public Activity $activity;
    /**
     * Create a new job instance.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->activity->delete();
            DB::commit();
            return $this->activity;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
