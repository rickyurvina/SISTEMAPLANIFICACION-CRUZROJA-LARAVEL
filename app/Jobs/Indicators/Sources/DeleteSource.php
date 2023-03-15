<?php

namespace App\Jobs\Indicators\Sources;

use App\Abstracts\Job;
use App\Models\Indicators\Sources\IndicatorSource;
use Illuminate\Support\Facades\DB;
use Throwable;


class DeleteSource extends Job
{


    protected $id;
    protected $source;

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
     * @return \Exception|Throwable|void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $this->source = IndicatorSource::find($this->id);
                $this->source->delete();
            });
        } catch (Throwable $e) {
            return $e;
        }
    }
}
