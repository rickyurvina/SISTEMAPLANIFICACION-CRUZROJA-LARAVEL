<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use Illuminate\Support\Facades\DB;


class ProjectUpdateStakeholder extends Job
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
     * @return bool
     */
    public function handle()
    {
        //
        try {
            DB::beginTransaction();
            $this->projectStakeholder=ProjectStakeholder::find($this->request->id);
            $this->projectStakeholder->update($this->request->all());
            DB::commit();
            return $this->projectStakeholder;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
