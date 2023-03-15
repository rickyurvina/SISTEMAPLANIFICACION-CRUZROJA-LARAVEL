<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\UpdatePlan;
use App\Models\Auth\User;
use App\Models\Strategy\Plan;
use App\Traits\Jobs;
use Illuminate\Support\Collection;
use Livewire\Component;

class PlanEdit extends Component
{
    use Jobs;

    public $planId;

    public $planTemplateEdition;
    public $codeEdition;
    public $nameEdition;
    public $descriptionEdition;
    public $responsableEdition;
    public $showVisionEdition = 0;
    public $visionEdition;
    public $showMissionEdition = 0;
    public $missionEdition;
    public $showTemporalityEdition = 0;
    public $temporalityStartEdition;
    public $temporalityEndEdition;
    public $statusEdition;
    public $elementChildName;
    /**
     * @var Collection|array
     */
    public $elementChildren;
    public $articulate=false;


    public Plan $plan;


    protected $listeners = ['loadForm' => 'loadFormPlan', 'resetEditModal' => '$refresh'];

    public function render()
    {
        $users=User::get();
        return view('livewire.strategy.plan-edit',compact('users'));
    }

    public function loadFormPlan($planId)
    {
        $this->resetModal();
        $this->plan = Plan::with('planTemplate', 'planDetails', 'planRegisteredTemplateDetails')->find($planId);
        $this->planId = $planId;
        $this->planTemplateEdition = $this->plan->planTemplate->description;
        $this->showVisionEdition = $this->plan->showVision;
        $this->showMissionEdition = $this->plan->showMission;
        $this->showTemporalityEdition = $this->plan->showTemporality;
        $this->statusEdition = $this->plan->status;
        $this->elementChildName = $this->plan->planRegisteredTemplateDetails->where('parent_id', null)->first()->name;
        $this->elementChildren = $this->plan->planRegisteredTemplateDetails->where('parent_id', null);

    }

    public function resetModal()
    {
        $this->emit('refreshParentComponent');
        $this->reset([
            'planId',
            'planTemplateEdition',
            'showVisionEdition',
            'showMissionEdition',
            'showTemporalityEdition',
            'statusEdition',
            'articulate',
        ]);
    }

    public function articulate(){
        $this->articulate=!$this->articulate;
    }
}
