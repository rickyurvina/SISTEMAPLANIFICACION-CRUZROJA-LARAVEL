<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\Project;
use Illuminate\Support\Facades\DB;

class DeleteProject extends Job
{

    protected $project;

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
        //
        try {
            DB::beginTransaction();
            $this->project=Project::destroy($this->request);
            DB::commit();
            return $this->project;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
