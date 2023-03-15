<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaMatrixReportAgreementCommitment;
use Illuminate\Support\Facades\DB;


class DeletePoaMatrixReportAgreementsCommitments extends Job
{
    protected $modelId;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->modelId = $model;
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
            $agreement =PoaMatrixReportAgreementCommitment::find($this->modelId);
            $agreement->delete();
            DB::commit();
            return $agreement;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }
    }
}
