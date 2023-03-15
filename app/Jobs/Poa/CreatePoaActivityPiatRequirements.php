<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaActivityPiatRequirements;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePoaActivityPiatRequirements extends Job
{
    protected $poaActivityPiatRequirement;

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
            $this->poaActivityPiatRequirement = PoaActivityPiatRequirements::create($this->request->all());
            DB::commit();
            return $this->poaActivityPiatRequirement;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
