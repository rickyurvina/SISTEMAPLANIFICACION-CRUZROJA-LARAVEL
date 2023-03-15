<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Activities\Task;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectCreateResultActivity extends Job
{
    protected $task;
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
            if ($this->request->id) {
                $this->task = Task::find($this->request->id);
                $this->task = $this->task->update($this->request->all());
            } else {
                $this->task = Task::create($this->request->all());
            }
            DB::commit();
            return $this->task;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
