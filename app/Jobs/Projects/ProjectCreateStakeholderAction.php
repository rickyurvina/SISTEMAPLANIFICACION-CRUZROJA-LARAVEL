<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Stakeholders\ProjectStakeholderActions;
use Exception;
use Illuminate\Support\Facades\DB;


class ProjectCreateStakeholderAction extends Job
{
    protected $projectStakeholder;

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
            $this->projectStakeholder = ProjectStakeholderActions::create($this->request->all());
            DB::commit();
            return $this->projectStakeholder;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
