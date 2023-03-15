<?php

namespace App\Http\Livewire\Projects\Evaluations;


use App\Models\Projects\Project;
use App\Models\Projects\ProjectEvaluation;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectCreateEvaluation extends Component
{
    use Jobs;

    public $project;
    public $name;
    public $methodology;
    public $phase;
    public $state;
    public $resources;
    public $systematization;
    public $variables = [];
    public $variablesSelect = [];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.evaluations.project-create-evaluation');
    }

    public function closeModal()
    {
        $this->reset([
            'name',
            'variables',
            'methodology',
            'phase',
            'state',
            'resources',
            'systematization',
            'variablesSelect',
        ]);
        $this->emit('updateEvaluations');
        $this->emit('toggleCreateEvaluation');
    }

    public function create()
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
            'user_id' => user()->id,
            'variables' => $this->variablesSelect,
            'prj_project_id' => $this->project->id,
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateEvaluation($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans('general.evaluation')]))->success()->livewire($this);
            $this->closeModal();
        } else {
            flash(trans('messages.error.updated') . $response['message'])->error()->livewire($this);
        }
    }

}
