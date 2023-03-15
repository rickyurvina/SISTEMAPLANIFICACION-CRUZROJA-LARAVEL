<?php

namespace App\Jobs\Indicators\Sources;

use App\Abstracts\Job;
use App\Models\Indicators\Sources\IndicatorSource;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateSource extends Job
{

    protected $request;
    protected $id;
    protected $source;

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
     * @return \Exception|Throwable|void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $this->source = Indicatorsource::find($this->id);
                $this->source->update($this->request->all());
            });
            return $this->source;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
