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

class UpdateProjectRisksClassification extends Job
{
    use Jobs;

    protected $id;
    protected array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id,array $data)
    {
        $this->id = $id;
        $this->data=$data;
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
                $riskClassification = ProjectRiskClassification::find($this->id);
                $riskClassification->update($this->data);
                return $riskClassification;
            });
        } catch (Throwable $e) {
            return $e;
        }
    }
}
