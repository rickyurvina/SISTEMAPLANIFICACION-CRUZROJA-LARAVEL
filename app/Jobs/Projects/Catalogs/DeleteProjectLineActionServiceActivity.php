<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use App\Models\Projects\Catalogs\ProjectLineActionServiceActivity;
use Exception;

class DeleteProjectLineActionServiceActivity extends Job
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var ProjectLineActionServiceActivity
     */
    protected ProjectLineActionServiceActivity $model;


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
        $this->model = ProjectLineActionServiceActivity::find($this->id);
        $this->model->delete();
        return trans_choice('messages.success.deleted',1,
            ['type' => __('general.lines_action_service_activity')]);
    }
}
