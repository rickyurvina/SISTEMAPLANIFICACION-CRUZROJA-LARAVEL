<?php

namespace App\Jobs\ResponsePlan\Task;

use App\Abstracts\Job;
use App\Models\ResponsePlan\Task;

class CreateTaskJob extends Job
{
    protected $request;
    protected Task $task;

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
     * @return Task
     */
    public function handle(): Task
    {
        $this->task = Task::create($this->request->all());
        $this->task->action->calculateAdvance();
        return $this->task;
    }
}
