<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\ProjectRescheduling;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectEditRescheduling extends Job
{
    protected $rescheduling;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request=$this->getRequestInstance($request);
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
            $this->rescheduling=ProjectRescheduling::find($this->request->id);
            $this->rescheduling=$this->rescheduling->update($this->request->all());
            DB::commit();
            return $this->rescheduling;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
