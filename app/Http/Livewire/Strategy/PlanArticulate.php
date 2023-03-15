<?php

namespace App\Http\Livewire\Strategy;

use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use Illuminate\Support\Collection;
use Livewire\Component;

class PlanArticulate extends Component
{
    public $planId = null;

    public ?Collection $planDetails = null, $plans, $planDetailsSelected = null, $planArticulations = null;
    public Plan $plan, $planSelected;
    public PlanRegisteredTemplateDetails $planRegisteredTemplateDetails, $planRegisteredTemplateDetailsSelected;
    public $selectedPlan = null;
    public $source = null;
    public array $target = [];
    public $articulations;
    public $plandetailId;

    protected $listeners = ['articulatePlan' => 'mount'];

    public function mount(Plan $plan, $planDetailId = null)
    {
        if ($plan) {
            $this->plan = $plan;
            $this->planId = $plan->id;
            $this->plans = Plan::with(['planRegisteredTemplateDetails', 'planDetails'])->where('id', '!=', $this->plan->id)->get();
            if (!is_null($this->plan->planRegisteredTemplateDetails->where('articulations', true)->first())) {
                $this->planRegisteredTemplateDetails = $this->plan->planRegisteredTemplateDetails->where('articulations', true)->first();
                $this->planDetails = $this->plan->planDetails->where('plan_registered_template_detail_id', $this->planRegisteredTemplateDetails->id);
                if ($planDetailId) {
                    $this->plandetailId=$planDetailId;
                    $this->planDetails = $this->planDetails->where('id', $planDetailId);
                }
                $this->articulations = \App\Models\Strategy\PlanArticulations::where('plan_source_id', $this->planId)->get();
            }
        }
    }

    public function updatedSelectedPlan()
    {
        if ($this->planDetails->count() == 1) {
            $this->updatedSource();
        }
        $this->planSelected = Plan::with(['planRegisteredTemplateDetails', 'planDetails'])->find($this->selectedPlan);
        $this->planRegisteredTemplateDetailsSelected = $this->planSelected->planRegisteredTemplateDetails->where('articulations', true)->first();
        $this->planDetailsSelected = $this->planSelected->planDetails->where('plan_registered_template_detail_id', $this->planRegisteredTemplateDetailsSelected->id);
    }

    public function articulate()
    {
        $this->target = array_filter($this->target);
        $array2 = array();
        $array2 = $this->planDetailsSelected->pluck('id', 'id');
        $arr = array_diff($array2->toArray(), $this->target);
        if ($this->planDetails->count() == 1) {
            $this->source = $this->planDetails->first()->id;
        }
        if (!is_null($this->source)) {
            $planArtt = \App\Models\Strategy\PlanArticulations::whereIn('plan_target_detail_id', $arr)->where('plan_source_detail_id', $this->source)->get();
            if ($planArtt) {
                $planArtt->each->delete();
            }
            foreach ($this->target as $target) {
                $planAr = \App\Models\Strategy\PlanArticulations::where('plan_source_detail_id', $this->source)
                    ->where('plan_target_detail_id', $target)->first();
                if (!$planAr) {
                    $planArticulation = new \App\Models\Strategy\PlanArticulations;
                    $planArticulation->fill([
                        'plan_source_id' => $this->plan->id,
                        'plan_source_registered_template_id' => $this->planRegisteredTemplateDetails->id,
                        'plan_source_detail_id' => $this->source,
                        'plan_target_detail_id' => $target,
                        'plan_target_id' => $this->planSelected->id,
                        'plan_target_registered_template_id' => $this->planRegisteredTemplateDetailsSelected->id,
                    ]);
                    $planArticulation->save();
                }

            }
        }
        $this->emit('planArticulated', $this->plan, $this->plandetailId );
        $this->target = [];
        $this->source = [];
        $this->selectedPlan = null;
        flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.articulations', 0)]))->success()->livewire($this);
        $this->resetForm();
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedSource()
    {
        if ($this->planDetails->count() == 1) {
            $this->source = $this->planDetails->first()->id;
        }
        $planArticulations = \App\Models\Strategy\PlanArticulations::where('plan_source_detail_id', $this->source)->get();
        $this->target = [];
        foreach ($planArticulations as $articulation) {
            $this->target += [$articulation->plan_target_detail_id => $articulation->plan_target_detail_id];
        }
    }

    public function render()
    {
        return view('livewire.strategy.plan-articulate');
    }
}
