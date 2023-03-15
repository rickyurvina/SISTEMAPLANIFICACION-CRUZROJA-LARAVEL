<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectLineAction;
use Exception;

class DeleteProjectLineAction extends Job
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var ProjectLineAction
     */
    protected ProjectLineAction $model;


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
        $this->model = ProjectLineAction::find($this->id);
        if ($this->model->services->count() == 0) {
            $this->model->delete();
        }else{
            throw new Exception(__('messages.error.delete'));
        }
        return trans_choice('messages.success.deleted',
            0,
            ['type' => trans_choice('general.lines_action', 0)]);
    }
}
