<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\CreatePlanTemplateDetail;
use App\Jobs\Strategy\DeletePlanTemplateDetail;
use App\Jobs\Strategy\UpdatePlanTemplate;
use App\Models\Strategy\PlanTemplate;
use App\Models\Strategy\PlanTemplateDetails;
use App\Traits\Jobs;
use Livewire\Component;

class TemplateEdit extends Component
{
    use Jobs;

    public $templateId;
    public $currentElementId;

    public $planType;
    public $description;
    public $vision;
    public $mission;
    public $temporality;
    public $parentId;
    public $name;
    public $indicators = 0;
    public $poaIndicators = 0;
    public $program = 0;
    public $objectiveType = 0;

    public $crePlanType = 0;
    public $creObjective = 0;
    public $articulations = 0;

    public $editionParentName;
    public $editionName;
    public $editionIndicators;
    public $editionPoaIndicators;
    public $editionProgram;
    public $editionArticulations;
    public $editionCreObjective;
    public $editionDelete;
    public $hasArticulations = null;
    public $hasPrograms = null;
    public $hasPoaIndicators = null;

    public PlanTemplate $planTemplate;

    protected $rules = [
        'parentId' => 'required',
        'name' => 'required|max:500|string',
    ];

    public function mount()
    {

        $this->planTemplate = PlanTemplate::find($this->templateId);
        $this->planType = $this->planTemplate->plan_type;
        $this->description = $this->planTemplate->description;
        $this->vision = $this->planTemplate->vision;
        $this->mission = $this->planTemplate->mission;
        $this->temporality = $this->planTemplate->temporality;
        if ($this->planType == PlanTemplate::PLAN_STRATEGY_CRE) {
            $this->crePlanType = 1;
        } else {
            $this->crePlanType = 0;
        }
        $this->hasArticulations = $this->planTemplate->planTemplateDetails->sum('articulations');
        $this->hasPrograms = $this->planTemplate->planTemplateDetails->sum('program');
        $this->hasPoaIndicators = $this->planTemplate->planTemplateDetails->sum('poa_indicators');
    }

    public function render()
    {
        $planTemplateDetails = new PlanTemplateDetails();
        $elementsTree = $planTemplateDetails->getElements($this->templateId);
        if (count($elementsTree) == 0) {
            $this->parentId = 0;
        }
        return view('livewire.strategy.template-edit')
            ->with('elementsTree', $elementsTree)
            ->with('htmlTree', $planTemplateDetails->htmlTree);
    }

    public function elementEdition($elementId)
    {
        $editionElement = PlanTemplateDetails::with('parentElement')->find($elementId);
        if ($editionElement->parentElement) {
            $this->editionParentName = $editionElement->parentElement->name;
        } else {
            $this->editionParentName = trans_choice('general.elements', 1);
        }
        $this->editionName = $editionElement->name;
        $this->editionIndicators = $editionElement->indicators;
        $this->editionPoaIndicators = $editionElement->poa_indicators;
        $this->editionProgram = $editionElement->program;
        $this->editionArticulations = $editionElement->articulations;
        $this->editionCreObjective = $editionElement->cre_objective;
        $editionDelete = new PlanTemplateDetails();
        if ($editionDelete->hasChildren($elementId)) {
            $this->editionDelete = 0;
        } else {
            $this->editionDelete = 1;
        }
        $this->currentElementId = $elementId;
    }

    public function elementDelete()
    {
        $response = $this->ajaxDispatch(new DeletePlanTemplateDetail($this->currentElementId));

        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.elements', 1)]))->success();
            return redirect()->route('templates.edit', ['template' => $this->templateId]);
        } else {
            flash($response['message'])->error()->livewire($this);

        }
    }

    public function submit()
    {
        $this->name = trim($this->name);

        $this->validate();

        $data = [
            'plan_template_id' => $this->templateId,
            'parent_id' => $this->parentId,
            'name' => $this->name,
            'indicators' => $this->indicators,
            'poa_indicators' => $this->poaIndicators,
            'program' => $this->program,
            'cre_objective' => $this->creObjective,
            'articulations' => $this->articulations,
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new CreatePlanTemplateDetail($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.elements', 1)]))->success();
            return redirect()->route('templates.edit', ['template' => $this->templateId]);
        } else {
            flash($response['message'])->error()->livewire($this);

        }
    }

    public function update()
    {
        $this->validate([
            'description' => 'required|max:255',
        ]);

        $data = [
            'id' => $this->templateId,
            'description' => $this->description,
            'vision' => $this->vision,
            'mission' => $this->mission,
            'temporality' => $this->temporality,
        ];

        $response = $this->ajaxDispatch(new UpdatePlanTemplate($this->templateId, $data));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.templates', 1)]))->success();
            return redirect()->route('templates.edit', ['template' => $this->templateId]);
        } else {
            flash($response['message'])->error()->livewire($this);

        }
    }

    public function updated($name, $value){
        if ($name=="program" && $value==false) {
            $this->poaIndicators = false;
        }
    }
}
