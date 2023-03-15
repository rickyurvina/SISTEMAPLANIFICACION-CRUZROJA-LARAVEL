<?php

namespace App\Jobs\Poa;


use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;

class UpdatePoaActivityPiatPlan extends Job
{
    protected $piatResult;
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
        try {
            DB::beginTransaction();

            $this->piatResult = \App\Models\Poa\Piat\PoaActivityPiatPlan::updateOrCreate(['id' => $this->request->id],
                                                                    $this->request->all());

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->piatResult = false;
            throw new \Exception($exception->getMessage());
        }

        return $this->piatResult;
    }
}
