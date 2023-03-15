<?php

namespace App\Jobs\Indicators\Units;

use App\Abstracts\Job;
use App\Models\Indicators\Units\IndicatorUnits;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateUnitIndicator extends Job
{
    protected $request;
    protected $id;
    protected $unitIndicator;

    /**
     * Create a new job instance.
     *
     * @param $request
     * @param $id
     */
    public function __construct($request, $id)
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
                $this->unitIndicator = IndicatorUnits::find($this->id);
                $this->unitIndicator->update($this->request->all());
            });
            return $this->unitIndicator;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
