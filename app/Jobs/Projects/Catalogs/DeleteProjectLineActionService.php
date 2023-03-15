<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use Exception;

class DeleteProjectLineActionService extends Job
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var ProjectLineActionService
     */
    protected ProjectLineActionService $model;


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
        $this->model = ProjectLineActionService::find($this->id);
        if ($this->model->lineActionActivities()->count() == 0) {
            $this->model->delete();
        }else{
            throw new Exception(__('messages.error.delete'));
        }
        return trans_choice('messages.success.deleted',0,
            ['type' => trans_choice('general.lines_action_service', 0)]);
    }
}
