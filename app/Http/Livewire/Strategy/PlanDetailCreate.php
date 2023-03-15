<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\CreatePlanDetail;
use App\Jobs\Strategy\DeletePlanDetail;
use App\Models\Admin\Perspective;
use App\Models\Poa\PoaProgram;
use App\Models\Projects\ProjectArticulations;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PlanDetailCreate extends Component
{
    use Jobs;

    public $code;
    public $name;
    public $registeredTemplateDetailId;
    public $parentId;
    public $creObjective;
    public $objectiveType = 0;
    public $perspective;
    public $templateDetail;
    public $planDetailId;

    public $planId;
    public $level;
    public $articulate = false;

    protected $listeners = ['loadDetailInfo', 'planDetailCreatedModalCreate' => '$refresh'];

    public function rules()
    {
        return
            [
                'code' => [
                    'required',
                    'max:5',
                    'alpha_num',
                    'alpha_dash',
                    Rule::unique('plan_details')->where('plan_id', $this->planId)->where('parent_id', $this->parentId)
                        ->where('deleted_at', null)
                ],
                'name' => 'required|max:500|min:5',
                'perspective' => 'required_if:objectiveType,1',
            ];
    }

    public function render()
    {
        if ($this->planDetailId) {
            $planDetail = PlanDetail::with(['planRegistered.childs.planDetails', 'plan'])->find($this->planDetailId);
            $children = $planDetail->planRegistered->childs->where('plan_id', $planDetail->plan_id);
        }

        $perspectives = Perspective::get();
        return view('livewire.strategy.plan-detail-create')
            ->with('planDetail', $planDetail ?? null)
            ->with('children', $children ?? null)
            ->with('perspectives', $perspectives);
    }

    public function loadDetailInfo($level, $registeredTemplateDetailId, $planDetailId)
    {
        $this->level = $level;
        $this->registeredTemplateDetailId = $registeredTemplateDetailId;
        $this->templateDetail = PlanRegisteredTemplateDetails::find($registeredTemplateDetailId);
        if ($planDetailId != '' && $this->level != 1) {
            $this->parentId = $planDetailId;
        } else {
            $this->parentId = null;
        }
        $this->planId = $this->templateDetail->plan_id;
        $this->level = $this->templateDetail->level;
        $this->creObjective = $this->templateDetail->cre_objective;
    }

    public function submit()
    {

        $this->validate();

        $data = [
            'plan_id' => $this->planId,
            'plan_registered_template_detail_id' => $this->registeredTemplateDetailId,
            'parent_id' => $this->level === 1 ? NULL : $this->parentId,
            'code' => $this->code,
            'name' => $this->name,
            'level' => $this->level,
            'company_id' => session('company_id'),
        ];

        if ($this->creObjective) {
            if ($this->objectiveType) {
                $data['organizational_development'] = true;
                $data['perspective'] = $this->perspective;
            } else {
                $data['mission_objective'] = true;
            }
        }

        $planTemplateDetailId = PlanRegisteredTemplateDetails::find($this->registeredTemplateDetailId)->parent_id;
        if ($planTemplateDetailId) {
            $planRegisteredTemplateDetailId = PlanRegisteredTemplateDetails::where('plan_id', $this->planId)
                ->where('plan_template_detail_id', $planTemplateDetailId)
                ->first()->id;
        } else {
            $planRegisteredTemplateDetailId = null;
        }

        $response = $this->ajaxDispatch(new CreatePlanDetail($data));

        if ($response['success']) {

            $this->planDetailId = $response['data']['id'];
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.elements', 1)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);

        }
    }

    public function delete($id)
    {
        $plan = PlanDetail::find($id);
        if ($plan->children->count() == 0) {
            if ($plan->planArticulationTarget->count() == 0) {
                if ($plan->indicators->count() == 0) {
                    $articulationsProject = ProjectArticulations::where('plan_target_detail_id', $id)->get();
                    if ($articulationsProject->count() == 0) {
                        $poa_programs = PoaProgram::where('plan_detail_id', $id)->get();
                        if ($poa_programs->count() == 0) {
                            $response = $this->ajaxDispatch(new DeletePlanDetail($plan));
                            if ($response['success']) {
                                flash(trans('general.deleted_element'))->success();

                            } else {
                                flash($response['message'])->error();
                            }
                        } else {
                            flash(trans('general.delete_program_message'))->info();
                        }
                    } else {
                        flash(trans('general.delete_strategy_message'))->info();
                    }
                } else {
                    flash(trans('general.delete_strategy_message'))->info();
                }
            } else {
                flash(trans('general.delete_strategy_message'))->info();
            }
        } else {
            flash(trans('general.delete_strategy_message'))->info();
        }
    }

    public function articulate()
    {
        $this->articulate = !$this->articulate;
    }

}
