<?php

namespace App\Jobs\Projects;

use App\Abstracts\Job;
use App\Models\Projects\ProjectEvaluation;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectCreateEvaluation  extends Job
{
    protected $evaluation;
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
            $this->evaluation = ProjectEvaluation::create($this->request->all());
            DB::commit();
            return $this->evaluation;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
