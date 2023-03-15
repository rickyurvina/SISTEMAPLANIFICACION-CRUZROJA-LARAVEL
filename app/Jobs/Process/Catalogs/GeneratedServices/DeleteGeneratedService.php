<?php

namespace App\Jobs\Process\Catalogs\GeneratedServices;

use App\Abstracts\Job;
use App\Models\Process\Catalogs\GeneratedService;
use Illuminate\Support\Facades\DB;

class DeleteGeneratedService extends Job
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $this->getRequestInstance($id);
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
            $generated_service =GeneratedService::find($this->id);
            $generated_service->delete();
            DB::commit();
            return $generated_service;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
