<?php

namespace App\Http\Livewire\ProjectsInternal\Formulation\Articulations;


use App\Models\Projects\ProjectArticulations;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProjectArticulate extends Component
{
    protected $listeners = ['articulateProject' => 'mount'];
    public ?Collection $planDetails = null, $plans, $planDetailsSelected = null, $planArticulations = null;
    public Plan $plan, $planSelected;
    public ?PlanRegisteredTemplateDetails $planRegisteredTemplateDetails, $planRegisteredTemplateDetailsSelected;
    public $selectedPlan = null;
    public $source = null;
    public array $target = [];
    public $articulations;
    public $projectId;

    public function mount($id = null)
    {
        $this->projectId = $id;
        if ($id) {
            $this->source = $id;
            $this->plans = Plan::get();
            $planArticulations = ProjectArticulations::where('prj_project_id', $this->source)->get();
            $this->target = [];
            foreach ($planArticulations as $articulation) {
                $this->target += [$articulation->plan_target_detail_id => $articulation->plan_target_detail_id];
            }
        }
    }

    public function updatedSelectedPlan()
    {
        $this->planSelected = Plan::with(['planRegisteredTemplateDetails','planDetails'])->find($this->selectedPlan);
        $this->planRegisteredTemplateDetailsSelected = $this->planSelected->planRegisteredTemplateDetails->where('articulations', true)->first();
        $this->planDetailsSelected = $this->planSelected->planDetails->where('plan_registered_template_detail_id', $this->planRegisteredTemplateDetailsSelected->id);
    }

    public function articulate()
    {
        $this->target = array_filter($this->target);
        $array2 = array();
        $array2 = $this->planDetailsSelected->pluck('id', 'id');
        $arr = array_diff($array2->toArray(), $this->target);
        if (!is_null($this->source)) {
            $planArtt = ProjectArticulations::whereIn('plan_target_detail_id', $arr)->where('prj_project_id', $this->source)->get();
            if ($planArtt) {
                $planArtt->each->delete();
            }
            foreach ($this->target as $target) {
                $planAr = ProjectArticulations::where('prj_project_id', $this->source)
                    ->where('plan_target_detail_id', $target)->first();
                if (!$planAr) {
                    $planArticulation = new ProjectArticulations;
                    $planArticulation->fill([
                        'prj_project_id' => $this->source,
                        'plan_target_detail_id' => $target,
                        'plan_target_id' => $this->planSelected->id,
                        'plan_target_registered_template_id' => $this->planRegisteredTemplateDetailsSelected->id,
                    ]);
                    $planArticulation->save();
                }
            }
        }
        $this->target = [];
        $this->source = [];
        $this->selectedPlan = null;
        $this->emit('projectArticulated', $this->projectId);
        flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.articulations', 2)]))->success()->livewire($this);
        $this->resetForm();
        $this->emit('toggleProjectArticulateModal');
    }


    public function render()
    {
        return view('livewire.projectsInternal.formulation.articulations.project-articulate');
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
}
