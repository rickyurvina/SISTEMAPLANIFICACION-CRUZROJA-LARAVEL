<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectEditCommunication extends Job
{
    protected $projectCommunication;
    protected $id;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $request)
    {
        //
        $this->request = $this->getRequestInstance($request);
        $this->id = $this->getRequestInstance($id);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
            DB::beginTransaction();
            $this->projectCommunication = ProjectCommunicationMatrix::find($this->id);
            $this->projectCommunication->update($this->request->all());
            DB::commit();
            return $this->projectCommunication;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
