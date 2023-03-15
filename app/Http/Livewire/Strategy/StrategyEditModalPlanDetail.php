<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\DeletePlanDetail;
use App\Models\Admin\Perspective;
use App\Models\Poa\PoaProgram;
use App\Models\Projects\ProjectArticulations;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Models\Strategy\PlanTemplateDetails;
use App\Traits\Jobs;
use Livewire\Component;

class StrategyEditModalPlanDetail extends Component
{
    use Jobs;

    public $planDetailId = null;
    public $articulate = false;
    public $rule;
    public bool $creObjective = false;
    public bool $missionObjective = false;
    public bool $organizationalDevelopment = false;
    public $perspective;
    public $planDetail;
    protected $listeners = ['loadPlanDetail' => 'mount', 'planDetailCreated' => '$refresh', 'itemDeleted' => '$refresh'];

    public function mount($id = null)
    {
        if ($id) {
            $this->planDetailId = $id;
        }
    }

    public function render()
    {
        $this->planDetail = PlanDetail::with(['planRegistered.childs.planDetails', 'plan'])->find($this->planDetailId);
        if ($this->planDetail) {
            $planTemplateDetail = PlanTemplateDetails::find($this->planDetail->planRegistered->plan_template_detail_id);
            $this->creObjective = $planTemplateDetail->cre_objective;
            $this->missionObjective = $this->planDetail->mission_objective;
            $this->organizationalDevelopment = $this->planDetail->organizational_development;
            $this->perspective =$this->planDetail->perspective;
        }

        $perspectives = Perspective::get()->pluck('name');

        if ($this->planDetailId) {
            if ($this->planDetail->level == 1) {
                $this->rule = 'required|max:5|alpha_num|alpha_dash|unique:plan_details,code,' . $this->planDetail->id . ',id,plan_id,' . $this->planDetail->plan_id . ',parent_id,NULL';
            } else {
                $this->rule = 'required|max:5|alpha_num|alpha_dash|unique:plan_details,code,' . $this->planDetail->id . ',id,plan_id,' . $this->planDetail->plan_id . ',parent_id,' . $this->planDetail->parent_id;
            }
            $children = $this->planDetail->planRegistered->childs->where('plan_id', $this->planDetail->plan_id);
        }
        return view('livewire.strategy.strategy-edit-modal-plan-detail')
            ->with('planDetail', $this->planDetail)
            ->with('children', $children ?? null)
            ->with('creObjective', $this->creObjective)
            ->with('mission_objective', $this->missionObjective)
            ->with('organizational_development', $this->organizationalDevelopment)
            ->with('perspective', $this->perspective)
            ->with('perspectives', $perspectives);
    }

    public function resetModal()
    {
        $this->reset([
            'planDetailId',
        ]);
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
                                flash(trans('general.deleted_element'))->success()->livewire($this);

                            } else {
                                flash($response['message'])->error()->livewire($this);
                            }
                        } else {
                            flash(trans('general.delete_program_message'))->info()->livewire($this);
                        }
                    } else {
                        flash(trans('general.delete_strategy_message'))->info()->livewire($this);
                    }
                } else {
                    flash(trans('general.delete_strategy_message'))->info()->livewire($this);
                }
            } else {
                flash(trans('general.delete_strategy_message'))->info()->livewire($this);
            }
        } else {
            flash(trans('general.delete_strategy_message'))->info()->livewire($this);
        }
    }

    public function articulate()
    {
        $this->articulate = !$this->articulate;
    }

    public function updateMissionObjective()
    {
        $this->missionObjective=true;
        $this->organizationalDevelopment=false;
        $this->planDetail->update(['mission_objective'=> $this->missionObjective,'organizational_development'=> $this->organizationalDevelopment]);
    }

    public function updateOrganizationalDevelopment()
    {
        $this->missionObjective=false;
        $this->organizationalDevelopment=true;
         $this->planDetail->update(['mission_objective'=> $this->missionObjective,'organizational_development'=> $this->organizationalDevelopment]);
    }

    public function updatedPerspective()
    {
        $this->planDetail->update(['perspective'=> $this->perspective]);
    }
}
