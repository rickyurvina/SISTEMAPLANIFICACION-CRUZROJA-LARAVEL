<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\CreatePlanDetail;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplateDetails;
use App\Traits\Jobs;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class StrategyPlanDetailCreateComponent extends Component
{
    use Jobs;

    public $planId;

    public string $newPlanDetail;
    public $code = null;
    public $objectiveType = 0;
    public $perspective;
    public $plan;
    public $planDetail;
    public $templateDetail;
    public $level = null;
    public $planDetailId = null;
    public $registeredTemplateDetailId = null;
    /**
     * @var int
     */
    public int $template_detail_id;


    public function rules()
    {
        return
            [
                'newPlanDetail' => 'required|min:5|max:500',
                'code' => [
                    'required',
                    'max:5',
                    'alpha_num',
                    'alpha_dash',
                    Rule::unique('plan_details')->where(function ($query) {
                        return $query->when($this->planDetail, function ($q) {
                            return $q->where('parent_id', $this->planDetail->id)->where('deleted_at',null);
                        }, function ($query) {
                            return $query->where('plan_id', $this->planId)->where('parent_id', null)->where('deleted_at', null);
                        });
                    })
                ],
            ];
    }

    public function mount($templateDetailId, $planId = null, $planDetailId = null)
    {
        $this->planId = $planId;
        if ($planId) {
            $this->plan = Plan::find($planId);
        }
        if ($templateDetailId) {
            $this->templateDetail = PlanRegisteredTemplateDetails::find($templateDetailId);
        }
        if ($planDetailId) {
            $this->planDetail = PlanDetail::find($planDetailId);
        }
        $this->planDetailId = $planDetailId;
        $this->template_detail_id = $templateDetailId;
        $this->init();
    }


    public function save()
    {
        $this->validate();

        $data = [
            'plan_id' => $this->planId,
            'plan_registered_template_detail_id' => $this->template_detail_id,
            'code' => $this->code,
            'parent_id' => $this->planDetail ? $this->planDetail->id : null,
            'name' => $this->newPlanDetail,
            'level' => $this->templateDetail->level,
            'mission_objective' => $this->templateDetail->cre_objective,
            'company_id' => session('company_id'),
        ];
        $response = $this->ajaxDispatch(new CreatePlanDetail($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.elements', 1)]))->success()->livewire($this);

        } else {
            flash($response['message'])->error()->livewire($this);
        }
        $this->init();
    }

    private function init()
    {
        $this->newPlanDetail = '';
        $this->code = '';
        $this->emit('planDetailCreated');
        $this->emit('planDetailCreatedModalCreate');
    }

    public function render()
    {
        return view('livewire.strategy.strategy-plan-detail-create-component');
    }
}
