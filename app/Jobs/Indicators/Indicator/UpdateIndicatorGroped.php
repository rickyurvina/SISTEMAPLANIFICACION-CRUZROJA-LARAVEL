<?php

namespace App\Jobs\Indicators\Indicator;

use App\Abstracts\Job;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Indicator\IndicatorParentChild;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateIndicatorGroped extends Job
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
                $this->indicator=Indicator::find($this->request->id);
                $this->indicator->update($this->request->all());
                $indicatorParentChild= IndicatorParentChild::where('parent_indicator',$this->indicator->id);
                $indicatorParentChild->delete();
                foreach ($this->request->child_indicator as $index => $child){
                    $parentChild= new IndicatorParentChild;
                    $parentChild->fill([
                        'parent_indicator'=>$this->indicator->id,
                        'child_indicator'=>$child
                    ]);
                    $parentChild->save();
                }
            });
            return $this->indicator;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
