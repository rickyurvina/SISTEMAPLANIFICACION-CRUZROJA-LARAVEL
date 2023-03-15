<?php

namespace App\Jobs\Risk;

use App\Abstracts\Job;
use App\Models\Risk\RiskAction;
use Exception;
use Illuminate\Support\Facades\DB;

class RiskCreateAction extends Job
{

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
            $action = RiskAction::create($this->request->all());
            DB::commit();
            return $action;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
