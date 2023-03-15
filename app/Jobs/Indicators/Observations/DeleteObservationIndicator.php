<?php

namespace App\Jobs\Indicators\Observations;

use App\Abstracts\Job;
use App\Models\Indicators\Observations\IndicatorObservations;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteObservationIndicator extends Job
{
    protected $id;
    protected $indicatorObservation;

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
            DB::transaction(function () {
                $this->indicatorObservation = IndicatorObservations::find($this->id);
                $this->indicatorObservation->delete();
            });
        } catch (Throwable $e) {
            return $e;
        }
    }
}
