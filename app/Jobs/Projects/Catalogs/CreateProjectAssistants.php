<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Http\FormRequest;
use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectLineAction;
use Exception;

class CreateProjectAssistants extends Job
{
    /**
     * @var FormRequest
     */
    protected FormRequest $request;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedDate)
    {
        $this->request = $this->getRequestInstance($validatedDate);
    }

    /**
     * Execute the job.
     *
     * @return string
     * @throws Exception
     */
    public function handle(): string
    {
        ProjectAssistant::create($this->request->all());
        return trans_choice('messages.success.added',
            0,
            ['type' => __('general.assistant')]);
    }
}
