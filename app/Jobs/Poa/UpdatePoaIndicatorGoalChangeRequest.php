<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaIndicatorGoalChangeRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdatePoaIndicatorGoalChangeRequest extends Job
{
    protected int $requestResult;
    protected $id;
    protected $request;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->status = $request['status'];
        $this->request = $this->getRequestInstance($request);
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
            $this->requestResult = PoaIndicatorGoalChangeRequest::where('id', $this->id)
                ->update($this->request->all());
            if ($this->status == PoaIndicatorGoalChangeRequest::STATUS_APPROVED) {
                $request = PoaIndicatorGoalChangeRequest::find($this->id);
                MeasureAdvances::where('id', $request->measure_advance_id)
                    ->update(['goal' => $request->new_value]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->requestResult = false;
            throw new Exception($exception->getMessage());
        }
        return $this->requestResult;
    }
}
