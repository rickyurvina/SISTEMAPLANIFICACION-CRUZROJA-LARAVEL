<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaActivityPiatReport;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePoaActivityPiatReport extends Job
{
    protected $poaActivityPiatReport;

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
            $this->poaActivityPiatReport = PoaActivityPiatReport::updateOrCreate(['id' => $this->request->id], 
                                                                        $this->request->all());
            DB::commit();
            return $this->poaActivityPiatReport;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
