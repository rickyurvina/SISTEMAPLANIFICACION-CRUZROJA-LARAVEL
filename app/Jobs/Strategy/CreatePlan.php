<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplateDetails;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreatePlan extends Job
{

    protected $plan;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return mixed
     * @throws Throwable
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->plan = Plan::create($this->request->all());
            $planTemplateDetails = PlanTemplateDetails::where('plan_template_id', $this->request->plan_template_id)->get();
            foreach ($planTemplateDetails as $planTemplateDetail) {
                $planTemplateDetailArray = $planTemplateDetail->toArray();
                unset($planTemplateDetailArray['id']);
                unset($planTemplateDetailArray['plan_template_id']);
                unset($planTemplateDetailArray['created_at']);
                unset($planTemplateDetailArray['updated_at']);
                $planTemplateDetailArray['plan_id'] = $this->plan->id;
                $planTemplateDetailArray['plan_template_detail_id'] = $planTemplateDetail->id;
                $planTemplateDetailArray['company_id'] = $this->plan->company_id;
                PlanRegisteredTemplateDetails::create($planTemplateDetailArray);
            }
            DB::commit();
            return $this->plan;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
