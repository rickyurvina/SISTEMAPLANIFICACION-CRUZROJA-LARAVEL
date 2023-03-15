<?php

namespace App\Jobs\Indicators\Units;

use App\Abstracts\Job;

use App\Models\Indicators\Units\IndicatorUnits;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteUnitIndicator extends Job
{

    protected $id;
    protected $unitIndicator;

    /**
     * Create a new job instance.
     *
     * @param $requesta
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
                $this->unitIndicator = IndicatorUnits::find($this->id);
                $this->unitIndicator->delete();
            });
        } catch (Throwable $e) {
            return $e;
        }
    }
}
