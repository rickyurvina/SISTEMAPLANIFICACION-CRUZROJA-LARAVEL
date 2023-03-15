<?php

namespace App\Jobs\Indicators\Thresholds;

use App\Abstracts\Job;
use App\Models\Indicators\Threshold\Threshold;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateThreshold extends Job
{

    protected $thresold;
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
                $this->thresold = Threshold::create($this->request->only('name'));
                $this->thresold->properties = $result;
                $this->thresold->save();
            });
            return $this->thresold;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
