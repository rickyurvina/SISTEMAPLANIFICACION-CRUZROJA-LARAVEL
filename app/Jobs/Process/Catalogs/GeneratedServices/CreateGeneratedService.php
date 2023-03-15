<?php

namespace App\Jobs\Process\Catalogs\GeneratedServices;

use App\Abstracts\Job;
use App\Models\Process\Catalogs\GeneratedService;
use Illuminate\Support\Facades\DB;

class CreateGeneratedService extends Job
{
    public $request;
    public $generated_service;

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
            $this->generated_service = GeneratedService::create($this->request->all());
            DB::commit();
            return $this->generated_service;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
