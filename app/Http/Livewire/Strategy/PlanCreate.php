<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\CreatePlan;
use App\Models\Auth\User;
use App\Models\Strategy\PlanTemplate;
use App\Traits\Jobs;
use Livewire\Component;

class PlanCreate extends Component
{
    use Jobs;

    public $planTemplate;
    public $code;
    public $name;
    public $description;
    public $responsable;
    public $showVision = 0;
    public $vision;
    public $showMission = 0;
    public $mission;
    public $showTemporality = 0;
    public $temporalityStart;
    public $temporalityEnd;
    public $planType;

    protected $rules = [
        'planTemplate' => 'required',
        'planType' => 'required',
        'code' => 'required|max:5|alpha_num|alpha_dash',
        'name' => 'required|max:500',
        'description' => 'required|max:500|min:10',
        'vision' => 'required_if:showVision,true|min:10|max:500|nullable',
        'mission' => 'required_if:showMission,true|min:10|max:500|nullable',
        'temporalityStart' => 'required_if:showTemporality,true|numeric|min:2020|nullable',
        'temporalityEnd' => 'required_if:showTemporality,true|numeric|after:temporalityStart|nullable',
        'responsable' => 'required',
    ];

    public function render()
    {
        $planTemplates = PlanTemplate::active()->get();
        $users=User::collect();
        return view('livewire.strategy.plan-create', compact('planTemplates','users'));
    }

    /**
     * PLan selected management
     *
     */
    public function planTemplateSelected()
    {
        $planTemplate = PlanTemplate::find($this->planTemplate);
        $this->showVision = $planTemplate->vision;
        $this->showMission = $planTemplate->mission;
        $this->showTemporality = $planTemplate->temporality;
        $this->planType = $planTemplate->plan_type;
    }

    /**
     * Store Plan head information
     *
     */
    public function submit()
    {
        $this->validate();

        $data = [
            'plan_template_id' => $this->planTemplate,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'plan_type' => $this->planType,
            'showVision' => $this->showVision,
            'vision' => $this->vision,
            'showMission' => $this->showMission,
            'mission' => $this->mission,
            'showTemporality' => $this->showTemporality,
            'temporality_start' => $this->temporalityStart,
            'temporality_end' => $this->temporalityEnd,
            'responsable' => $this->responsable,
            'status' => 'draft',
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new CreatePlan($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.plan', 1)]))->success();
            return redirect()->route('plans.index');
        } else {
            flash($response['message'])->error()->livewire($this);

        }
    }
}
