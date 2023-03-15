<?php

namespace App\Jobs\ResponsePlan\Task;

use App\Abstracts\Job;
use App\Models\ResponsePlan\Task;

class DeleteTaskJob extends Job
{
    protected Task $task;

    /**
     * Create a new job instance.
     *
     * @param $task
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Task::destroy($this->task->id);
        return true;
    }
}
