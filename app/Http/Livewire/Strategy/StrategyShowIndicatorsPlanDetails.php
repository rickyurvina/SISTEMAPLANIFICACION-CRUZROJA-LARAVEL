<?php

namespace App\Http\Livewire\Strategy;

use App\Models\Measure\Measure;
use App\Models\Strategy\PlanDetail;
use Livewire\Component;

class StrategyShowIndicatorsPlanDetails extends Component
{

    public $planDetailId = null;

    public $search = '';

    public $type = null;

    public $planRegisteredTemplateDetailsBreadcrumbs;

    protected $listeners = ['renderPlanDetailIndicators' => 'render', 'weightUpdated' => 'render'];

    public function mount($planDetailId = null, $type = null, $navigation = null)
    {
        $planDetail = PlanDetail::with(['planRegistered', 'plan'])->find($planDetailId);
        $planRegisteredTemplateDetail = $planDetail->planRegistered;
        $element = array();
        $parent_id = $planDetail->parent_id;
        $count = count($navigation);
        if (!$parent_id) {
            $navigation[$count - 1]['link'] = route('plans.detail',
                [
                    'plan' => $planDetail->plan->id,
                    'level' => $planRegisteredTemplateDetail->level,
                    'planDetailId' => $parent_id,
                ]);
        } else {
            $navigation[$count - 1]['link'] = route('plans.detail',
                [
                    'plan' => $planRegisteredTemplateDetail->id,
                    'planDetailId' => $parent_id,
                    'detail' => $planRegisteredTemplateDetail->id
                ]);
        }

        $element['name'] = "INDICADORES";
        $element['link'] = "";
        $element['first'] = 0;
        array_push($navigation, $element);

        $this->planRegisteredTemplateDetailsBreadcrumbs = $navigation;
        $this->planDetailId = $planDetailId;
        $this->type = $type;
    }

    public function render()
    {
        $search = $this->search;
        $planDetail = PlanDetail::find($this->planDetailId);
        $measures = Measure::orderBy('id','asc')->where('indicatorable_id', $this->planDetailId)
            ->where('indicatorable_type', PlanDetail::class)
            ->when($search, function ($q, $search) {
                $q->where('name', 'iLIKE', '%' . $search . '%');
            })->with('scoringType')->get();
        return view('livewire.strategy.strategy-show-indicators-plan-details',
            [
                'measures' => $measures,
                'planDetail' => $planDetail,
            ]);

    }
}
