<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateMatrixReportBeneficiaries extends Job
{
    protected $matrixReportAgreComm;
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
     * @return mixed
     * @throws Exception        $this->request = $this->getRequestInstance($request);

     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->piatResult = false;
            throw new Exception($exception->getMessage());
        }
    }
}
