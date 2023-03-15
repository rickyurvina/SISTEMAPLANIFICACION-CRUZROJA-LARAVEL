<?php

namespace App\Jobs\Risk;

use App\Abstracts\Job;
use App\Models\Risk\Risk;

class UpdateRisk extends Job
{
    protected int $id;
    protected int $riskResult;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param $request
     * @param $id
     */
    public function __construct($request, $id)
    {
        $this->id = $id;
        $this->request = $this->getRequestInstance($request);
    }

    public function handle()
    {
        $risk=Risk::find($this->id);
        $risk->update($this->request->all());
//        $this->riskResult = Risk::where('id', $this->id)->update($this->request->all());
        return $risk;
    }

}
