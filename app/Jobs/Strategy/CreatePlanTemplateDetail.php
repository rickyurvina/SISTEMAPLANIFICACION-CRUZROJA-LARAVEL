<?php

namespace App\Jobs\Strategy;

use App\Abstracts\Job;
use App\Models\Strategy\PlanTemplate;
use App\Models\Strategy\PlanTemplateDetails;
use Throwable;

class CreatePlanTemplateDetail extends Job
{
    protected $planTemplateDetail;

    protected $request;

    /**
     * CreatePlanTemplateDetail constructor.
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
     * @throws Throwable
     */
    public function handle()
    {
        $data = [
            'plan_template_id' => $this->request->plan_template_id,
            'name' => $this->request->name,
            'indicators' => $this->request->indicators,
            'poa_indicators' => $this->request->poa_indicators,
            'program' => $this->request->program,
            'articulations' => $this->request->articulations,
            'cre_objective' => $this->request->cre_objective,
            'company_id' => $this->request->company_id,
        ];

        $planTemplateDetail = new PlanTemplateDetails();
        if ($this->request->parent_id == 0) {
            $level = 1;
            $totalNodes = $planTemplateDetail->nodeCount($level, $this->request->plan_template_id) + 1;
            $data['level'] = $level;
            $data['order'] = $totalNodes;
        }
        else {
            $level = $planTemplateDetail->getLevel($this->request->parent_id) + 1;
            $totalNodes = $planTemplateDetail->nodeCount($level, $this->request->plan_template_id) + 1;
            $data['level'] = $level;
            $data['order'] = $totalNodes;
            $data['parent_id'] = $this->request->parent_id;
        }

        $this->planTemplateDetail = PlanTemplateDetails::create($data);

        return $this->planTemplateDetail;
    }
}
