<?php

namespace App\Jobs\ResponsePlan\Task;

use App\Abstracts\Job;
use App\Models\ResponsePlan\Task;

class UpdateTaskJob extends Job
{
    protected int $id;
    protected int $taskResult;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $request
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->taskResult = Task::where('id', $this->id)->update($this->request->all());
        return $this->taskResult;
    }
}
