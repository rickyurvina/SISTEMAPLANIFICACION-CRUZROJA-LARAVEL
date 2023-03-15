<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectAssistant;
use Exception;

class DeleteProjectAssistant extends Job
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var ProjectAssistant
     */
    protected ProjectAssistant $model;

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
        $this->model = ProjectAssistant::find($this->id);
        $this->model->delete();
        return trans_choice('messages.success.deleted',
            0,
            ['type' => trans_choice('general.assistant', 0)]);
    }
}
