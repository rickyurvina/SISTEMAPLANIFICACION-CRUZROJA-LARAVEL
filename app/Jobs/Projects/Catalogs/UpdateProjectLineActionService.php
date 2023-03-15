<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use Exception;

class UpdateProjectLineActionService extends Job
{
    /**
     * @var ProjectLineActionService
     */
    protected ProjectLineActionService $model;

    /**
     * @var array
     */
    protected array $newData;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProjectLineActionService $model, array $newData)
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
            ['type' => __('general.lines_action_service')]);
    }
}
