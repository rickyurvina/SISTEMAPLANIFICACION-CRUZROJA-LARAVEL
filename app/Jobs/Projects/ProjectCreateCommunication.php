<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Models\Projects\Stakeholders\ProjectStakeholderActions;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectCreateCommunication extends Job
{
    protected $projectCommunication;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
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
            DB::beginTransaction();
            $this->projectCommunication = ProjectCommunicationMatrix::create($this->request->all());
            DB::commit();
            return $this->projectCommunication;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
