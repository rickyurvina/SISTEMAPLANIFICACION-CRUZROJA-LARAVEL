<?php

namespace App\Jobs\Process\Catalogs\GeneratedServices;

use App\Abstracts\Job;
use App\Models\Process\Catalogs\GeneratedService;
use Illuminate\Support\Facades\DB;

class UpdateGeneratedService extends Job
{
    protected $request;
    protected $id;
    public $generated_service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$id)
    {
        $this->request = $this->getRequestInstance($request);
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
            DB::transaction(function () {
                $this->generated_service = GeneratedService::find($this->id);
                $this->generated_service->update($this->request->all());
            });
            return $this->generated_service;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
