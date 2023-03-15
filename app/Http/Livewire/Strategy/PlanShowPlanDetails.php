<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\DeletePlan;
use App\Jobs\Strategy\DeletePlanDetail;
use App\Models\Poa\PoaProgram;
use App\Models\Projects\ProjectArticulations;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PlanShowPlanDetails extends Component
{
    use Jobs;

    public $plan_id = null;
    public $rule;

    /**
     * @var Plan
     */
    public Plan $plan;
    /**
     * @var int
     */
    public int $template_detail_id;

    public $planRegisteredTemplateDetail;

    protected $listeners = ['planDetailCreated' => '$refresh', 'deletePlanDetailModal' => 'delete'];

    public function mount(Plan $plan, int $planRegisteredTemplateDetailId)
    {
        $this->plan = $plan;
        $this->plan_id = $plan->id;
        $this->planRegisteredTemplateDetail = PlanRegisteredTemplateDetails::find($planRegisteredTemplateDetailId);
        $this->template_detail_id = $this->planRegisteredTemplateDetail->id;
    }

    public function render()
    {
        $planDetails = PlanDetail::orderBy('id', 'asc')->where('plan_id', $this->plan->id)
            ->where('parent_id', null)
            ->where('plan_registered_template_detail_id', $this->template_detail_id)->get();
        $planDetail = $planDetails->first();

        return view('livewire.strategy.plan-show-plan-details', compact('planDetails', 'planDetail'));
    }

    public function openModalDelete($id)
    {
        $this->dispatchBrowserEvent('deletePlanDetail', ['id' => $id]);
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
        $this->emitSelf('planDetailCreated');
    }

    public function makeRule(PlanDetail $pD)
    {
        $this->rule = 'required|max:5|alpha_num|alpha_dash|unique:plan_details,code,' . $pD->id . ',id,plan_id,' . $pD->plan_id;
    }
}
