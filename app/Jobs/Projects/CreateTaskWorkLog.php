<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Activities\TaskWorkLog;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateTaskWorkLog extends Job
{

    protected $task;
    protected $workLog;

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
        try {
            DB::beginTransaction();
            $this->workLog=TaskWorkLog::create($this->request->all());
            DB::commit();
            return $this->workLog;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
