<?php

namespace App\Jobs\Process;

use App\Abstracts\Job;
use App\Models\Process\NonConformitiesActions;
use Illuminate\Support\Facades\DB;

class CreateNonConformityAction extends Job
{
    public $request;
    public $action;
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
            DB::beginTransaction();
            $this->action = NonConformitiesActions::create($this->request->all());
            DB::commit();
            return $this->action;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
