<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\NonConformities;
use Illuminate\Support\Facades\DB;

class CreateNonConformity extends Job
{
    protected $request;
    protected $non_conformity;

    /**
     * Create a new job instances
     * @param $request
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
            DB::beginTransaction();
            $this->non_conformity = NonConformities::create($this->request->all());
            DB::commit();
            return $this->non_conformity;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
