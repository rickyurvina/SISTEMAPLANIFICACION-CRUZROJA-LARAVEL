<?php

namespace App\Jobs\Indicators\Sources;

use App\Abstracts\Job;
use App\Models\Indicators\Sources\IndicatorSource;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateSource extends Job
{

    protected $source;
    protected $request;

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
     * @return \Exception|Throwable|void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $this->source = IndicatorSource::create($this->request->all());
            });
            return $this->source;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
