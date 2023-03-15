<?php

namespace App\Jobs\Risk;

use App\Abstracts\Job;
use App\Models\Risk\Risk;
use Illuminate\Support\Facades\DB;

class CreateRisk extends Job
{

    protected $request;
    protected Risk $risk;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     *
     * @return Risk
     */
    public function handle(): Risk
    {
        try {
            DB::beginTransaction();
            $this->risk = Risk::create($this->request->all());
            DB::commit();
            return $this->risk;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw  new \Exception($exception->getMessage());
        }
    }
}
