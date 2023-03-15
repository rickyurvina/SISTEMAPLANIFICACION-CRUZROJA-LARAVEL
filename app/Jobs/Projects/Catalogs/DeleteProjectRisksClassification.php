<?php

namespace App\Jobs\Projects\Catalogs;

use App\Abstracts\Job;
use App\Models\Projects\Catalogs\ProjectRiskClassification;
use App\Traits\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DeleteProjectRisksClassification extends Job
{
    use Jobs;

    protected $id;

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
            $riskClassification =ProjectRiskClassification::find($this->id);
            $riskClassification->delete();
            DB::commit();
            return $riskClassification;
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }
}
