<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\PoaIndicatorGoalChangeRequest as PoaIndicatorGoalChangeRequestModel;
use Exception;

class CreatePoaIndicatorGoalChangeRequest extends Job
{
    protected $poaGoalChangeRequest;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->poaGoalChangeRequest = PoaIndicatorGoalChangeRequestModel::create($this->request->all());
            return $this->poaGoalChangeRequest;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
