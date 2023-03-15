<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectLineAction;
use Exception;

class UpdateProjectLineAction extends Job
{
    /**
     * @var ProjectLineAction
     */
    protected ProjectLineAction $model;

    /**
     * @var array
     */
    protected array $newData;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProjectLineAction $model, array $newData)
    {
        $this->model = $model;
        $this->newData = $newData;
    }

    /**
     * Execute the job.
     *
     * @return string
     * @throws Exception
     */
    public function handle(): string
    {
        $this->model->update($this->newData);
        return trans_choice('messages.success.updated',
            0,
            ['type' => __('general.lines_action')]);
    }
}
