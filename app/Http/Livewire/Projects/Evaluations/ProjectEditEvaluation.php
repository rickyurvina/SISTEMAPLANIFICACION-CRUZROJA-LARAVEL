<?php

namespace App\Http\Livewire\Projects\Evaluations;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectEvaluation;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectEditEvaluation extends Component
{
    use Jobs;
    public $project;
    public $name;
    public $methodology;
    public $phase;
    public $state;
    public $evaluation;
    public $resources;
    public $systematization;
    public $variablesSelect = [];
    public $existingVariables = [];

    protected $listeners = ['openEditEvaluation'];

    public function openEditEvaluation(int $id)
    {
        $this->evaluation = ProjectEvaluation::find($id);
        $this->name = $this->evaluation->name;
        $this->methodology = $this->evaluation->name;
        $this->systematization = $this->evaluation->systematization;
        $this->phase = $this->evaluation->phase;
        $this->state = $this->evaluation->state;
        $this->variablesSelect = $this->evaluation->variables;

        foreach (ProjectEvaluation::VARIABLES as $item) {
            $element = [];
            $element['id'] = $item;
            $element['name'] = $item;
            if (in_array($item, $this->variablesSelect)) {
                $element['selected'] = true;
            }
            array_push($this->existingVariables, $element);
        }
        $this->emit('refreshDropdown');
    }

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.evaluations.project-edit-evaluation');
    }

    public function edit()
    {
        $data = $this->validate([
            'name' => 'required|max:255',
            'variablesSelect.*' => 'required',
            'methodology' => 'required|max:255',
            'phase' => 'required|max:255',
            'state' => 'required|max:255',
            'systematization' => 'required',
        ]);
        $data += [
            'id' => $this->evaluation->id,
            'user_id' => user()->id,
            'variables' => $this->variablesSelect,
            'prj_project_id' => $this->project->id,
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectEditEvaluation($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans('general.evaluation')]))->success()->livewire($this);
            $this->closeModal();
        } else {
            flash(trans('messages.error.updated') . $response['message'])->error()->livewire($this);
        }
    }

    public function closeModal()
    {
        $this->reset([
            'name',
            'methodology',
            'phase',
            'state',
            'resources',
            'systematization',
            'variablesSelect',
            'existingVariables',
        ]);
        $this->emit('updateEvaluations');
        $this->emit('toggleEditEvaluation');
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm(){
        $this->reset([
            'name',
            'methodology',
            'phase',
            'state',
            'resources',
            'systematization',
            'variablesSelect',
            'existingVariables',
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

}
