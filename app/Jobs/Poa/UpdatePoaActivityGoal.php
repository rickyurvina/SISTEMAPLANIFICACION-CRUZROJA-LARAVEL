<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdatePoaActivityGoal extends Job
{
    protected bool $poaActivityGoalResult;
    protected $id;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $goalTotal = 0;
            $progressTotal = 0;
            foreach ($this->request as $item) {
                $measureAdvance = MeasureAdvances::find($item['id']);
                $measureAdvance->goal = $item['goal'];
                $measureAdvance->men = $item['men'];
                $measureAdvance->women = $item['women'];
                $measureAdvance->actual = $item['actual'] + $item['men'] + $item['women'];
                $measureAdvance->save();
                $goalTotal += $item['goal'];
                $progressTotal += $item['actual'] + $item['men'] + $item['women'];
            }
            PoaActivity::find($this->id)
                ->update([
                    'goal' => $goalTotal,
                    'progress' => $progressTotal,
                ]);
            DB::commit();
            $this->poaActivityGoalResult = true;
            return $measureAdvance;
        } catch (Exception $exception) {
            DB::rollBack();
            $this->poaActivityGoalResult = false;
            throw new Exception($exception->getMessage());
        }
    }
}
