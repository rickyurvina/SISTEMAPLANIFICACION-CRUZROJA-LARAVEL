<?php

namespace App\Http\Livewire\Strategy;

use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use Illuminate\Support\Collection;
use Livewire\Component;

class StrategyPlanArticulations extends Component
{

    public $planId = null;

    public ?Collection $planDetails = null, $plans, $planDetailsSelected = null, $planArticulations = null;
    public Plan $plan, $planSelected;
    public PlanRegisteredTemplateDetails $planRegisteredTemplateDetails, $planRegisteredTemplateDetailsSelected;
    public $selectedPlan = null;
    public $source = null;
    public array $target = [];
    public $articulations;

    protected $listeners = ['planArticulated' => 'mount'];

    public function mount(Plan $plan, $planDetailId = null)
    {
        if ($plan) {
            $this->plan = $plan;
            $this->planId = $plan->id;
            $this->plans = Plan::where('id', '!=', $this->plan->id)->get();
            if (!is_null($this->plan->planRegisteredTemplateDetails->where('articulations', true)->first())) {
                $this->planRegisteredTemplateDetails = $this->plan->planRegisteredTemplateDetails->where('articulations', true)->first();
                $this->planDetails = $this->plan->planDetails->where('plan_registered_template_detail_id', $this->planRegisteredTemplateDetails->id);
                $this->articulations = \App\Models\Strategy\PlanArticulations::where('plan_source_id', $this->planId)->
                when($planDetailId, function ($q, $planDetailId) {
                    $q->where('plan_source_detail_id', $planDetailId);
                })->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.strategy.strategy-plan-articulations');
    }
}
