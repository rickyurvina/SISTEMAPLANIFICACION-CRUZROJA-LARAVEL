<?php

namespace App\Jobs\Indicators\Indicator;

use App\Abstracts\Job;
use App\Models\Indicators\Indicator\Indicator;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteIndicator extends Job
{

    protected $id;

    protected $indicator;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $this->getRequestInstance($id);
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->indicator = Indicator::find($this->id);
            if ($this->indicator->type == Indicator::TYPE_GROUPED) {
                $this->indicator->delete();
            } else {
                $goalIndicator = $this->indicator->total_goal_value;
                $actualValue = $this->indicator->total_actual_value;
                $goals = $this->indicator->indicatorGoals->sum('goal_value');
                $progress = $this->indicator->indicatorGoals->sum('actual_value');
                if ($progress > 0 || $actualValue > 0) {
                    throw  new \Exception(trans('general.cant_delete_indicator'));
                } else {
                    $this->indicator->delete();
                }
            }

            DB::commit();
            return $this->indicator;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }

    }
}
