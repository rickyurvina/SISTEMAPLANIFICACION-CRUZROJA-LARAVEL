<?php

namespace App\Jobs\Indicators\Indicator;

use App\Abstracts\Job;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Indicator\IndicatorParentChild;
use App\Models\Indicators\Threshold\Threshold;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateIndicatorGrouped extends Job
{
    protected $request;
    protected $indicator;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
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
                $this->indicator = Indicator::create($this->request->all());
                $result = array();
                if ($this->request->threshold_type == Threshold::ASCENDING) {
                    $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->maxAD];
                    $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minAW, 'max' => $this->request->maxAW];
                    $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->minAS];
                } else if ($this->request->threshold_type == Threshold::DESCENDING) {
                    $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->maxDD];
                    $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minDW, 'max' => $this->request->maxDW];
                    $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->minDS];
                } else if ($this->request->threshold_type == Threshold::TOLERANCE) {
                    $result[0] = ['state' => Threshold::DANGER, 'max' => $this->request->maxTD];
                    $result[1] = ['state' => Threshold::WARNING, 'min' => $this->request->minTW, 'max' => $this->request->maxTW];
                    $result[2] = ['state' => Threshold::SUCCESS, 'min' => $this->request->minTS];
                }
                $this->indicator->threshold_properties = $result;
                $this->indicator->save();

                foreach ($this->request->child_indicator as $index => $child) {
                    $parentChild = new IndicatorParentChild;
                    $parentChild->fill([
                        'parent_indicator' => $this->indicator->id,
                        'child_indicator' => $child
                    ]);
                    $periods = count(GoalIndicators::where('indicators_id', $child)->get());
                    $parentChild->save();
                }
                $childs=GoalIndicators::whereIn('indicators_id',$this->request->child_indicator)->get();
                $goal = 0;
                $progress = 0;
                for ($i = 0; $i < $periods; $i++) {
                    $goal=$childs->where('period',$i+1)->sum('goal_value');
                    $progress=$childs->where('period',$i+1)->sum('actual_value');
                    GoalIndicators::create([
                        'goal_value' => $goal,
                        'actual_value' => $progress,
                        'indicators_id' => $this->indicator->id,
                        'period' => $i + 1,
                        'user_updated' => auth()->user()->id,
                    ]);
                }
            });
            return $this->indicator;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
