<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\Activity;
use Illuminate\Support\Facades\DB;

class EditActivity extends Job
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
            $this->activity=Activity::find($this->request->id);
            $this->activity =  $this->activity->update($this->request->all());
            DB::commit();
            return $this->activity;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
