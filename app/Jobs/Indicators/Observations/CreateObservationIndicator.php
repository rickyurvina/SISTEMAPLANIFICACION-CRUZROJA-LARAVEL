<?php

namespace App\Jobs\Indicators\Observations;

use App\Abstracts\Job;
use App\Models\Indicators\Observations\IndicatorObservations;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateObservationIndicator extends Job
{

    protected $request;

    protected $indicatorObservation;

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
            DB::transaction(function () {
                $this->indicatorObservation = IndicatorObservations::create($this->request->all());
            });
            return $this->indicatorObservation;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
