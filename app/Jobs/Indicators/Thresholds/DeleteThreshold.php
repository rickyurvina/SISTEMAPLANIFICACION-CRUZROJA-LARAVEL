<?php

namespace App\Jobs\Indicators\Thresholds;

use App\Abstracts\Job;
use App\Models\Indicators\Threshold\Threshold;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteThreshold extends Job
{

    protected $id;
    protected $threshold;

    /**
     * Create a new job instance.
     *
     * @param $id
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
            DB::transaction(function () {
                $this->threshold = Threshold::find($this->id);
                $this->threshold->delete();
            });
            return $this->threshold;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
