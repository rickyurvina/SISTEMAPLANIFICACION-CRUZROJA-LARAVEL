<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectFunder;
use Exception;

class DeleteProjectFunder extends Job
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var ProjectFunder
     */
    protected ProjectFunder $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->id = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return string
     * @throws Exception
     */
    public function handle(): string
    {
        $this->model = ProjectFunder::find($this->id);
        $this->model->delete();
        return trans_choice('messages.success.deleted',
            0,
            ['type' => trans_choice('general.funder', 1)]);
    }
}
