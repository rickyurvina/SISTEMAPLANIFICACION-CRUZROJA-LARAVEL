<?php

namespace App\Jobs\Indicators\Thresholds;

use App\Abstracts\Job;
use App\Models\Indicators\Threshold\Threshold;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateThreshold extends Job
{
    protected $request;
    protected $id;
    protected $threshold;

    /**
     * Create a new job instance.
     *
     * @param $request
     * @param $id
     */
    public function __construct($request, $id)
    {
        //
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
                $result = array();
                $result[0] = [Threshold::ASCENDING, Threshold::DANGER, 'maxAD', $this->request->input('maxAD')];
                $result[1] = [Threshold::ASCENDING, Threshold::WARNING, 'minAW', $this->request->input('minAW')];
                $result[2] = [Threshold::ASCENDING, Threshold::WARNING, 'maxAW', $this->request->input('maxAW')];
                $result[3] = [Threshold::ASCENDING, Threshold::SUCCESS, 'minAS', $this->request->input('minAS')];
                $result[4] = [Threshold::DESCENDING, Threshold::DANGER, 'maxDD', $this->request->input('maxDD')];
                $result[5] = [Threshold::DESCENDING, Threshold::WARNING, 'minDW', $this->request->input('minDW')];
                $result[6] = [Threshold::DESCENDING, Threshold::WARNING, 'maxDW', $this->request->input('maxDW')];
                $result[7] = [Threshold::DESCENDING, Threshold::SUCCESS, 'minDS', $this->request->input('minDS')];
                $result[8] = [Threshold::TOLERANCE, Threshold::DANGER, 'maxTD', $this->request->input('maxTD')];
                $result[9] = [Threshold::TOLERANCE, Threshold::WARNING, 'minTW', $this->request->input('minTW')];
                $result[10] = [Threshold::TOLERANCE, Threshold::WARNING, 'maxTW', $this->request->input('maxTW')];
                $result[11] = [Threshold::TOLERANCE, Threshold::SUCCESS, 'minTS', $this->request->input('minTS')];
                $this->threshold = Threshold::find($this->id);
                $this->threshold->update($this->request->only('name'));
                $this->threshold->properties = $result;
                $this->threshold->save();
            });
            return $this->threshold;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
