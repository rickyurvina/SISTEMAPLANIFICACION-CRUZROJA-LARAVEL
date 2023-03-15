<?php

namespace App\Jobs\Indicators\Units;

use App\Abstracts\Job;
use App\Models\Indicators\Units\IndicatorUnits;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateUnitIndicator extends Job
{

    protected $request;

    protected $unitIndicator;

    /**
     * Create a new job instance.
     *
     * @param $request
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
                $this->unitIndicator = IndicatorUnits::create($this->request->all());
            });
            return $this->unitIndicator;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
