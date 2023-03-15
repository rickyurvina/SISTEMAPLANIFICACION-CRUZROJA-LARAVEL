<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectLineAction;
use Exception;

class UpdateProjectAssistant extends Job
{
    /**
     * @var ProjectAssistant
     */
    protected ProjectAssistant $model;

    /**
     * @var array
     */
    protected array $newData;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProjectAssistant $model, array $newData)
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
            ['type' => __('general.assistant')]);
    }
}
