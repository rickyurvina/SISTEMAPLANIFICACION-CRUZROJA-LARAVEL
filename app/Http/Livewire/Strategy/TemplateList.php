<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\CreatePlanTemplate;
use App\Models\Strategy\PlanTemplate;
use App\Traits\Jobs;
use Livewire\Component;

class TemplateList extends Component
{
    use Jobs;

    public $planType;
    public $description;
    public $vision = 0;
    public $mission = 0;
    public $temporality = 0;

    protected $rules = [
        'planType' => 'required',
        'description' => 'required|max:500',
    ];

    public function render()
    {
        $planTypes = config('constants.catalog.PLAN_TYPES');
        $planTemplates = PlanTemplate::orderBy('id','asc')->collect()->where('company_id', session('company_id'));
        return view('livewire.strategy.template-list', compact('planTypes', 'planTemplates'));
    }

    public function submit()
    {
        $this->validate();

        $data = [
            'plan_type' => $this->planType,
            'description' => $this->description,
            'vision' => $this->vision,
            'mission' => $this->mission,
            'temporality' => $this->temporality,
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new CreatePlanTemplate($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.templates', 1)]))->success()->livewire($this);
            return redirect()->route('templates.index');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
