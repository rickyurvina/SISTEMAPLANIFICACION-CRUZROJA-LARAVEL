<?php

namespace App\Http\Livewire\ProjectsInternal\Layout;

use App\Http\Livewire\Components\Modal;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectStateValidations;
use Livewire\Component;

class ProjectInternalNavigation extends Modal
{

    public $project;
    public $page;
    public $phase = true;
    public $transition = null;
    public $resume = [];
    public $departments = [];
    public $accept = [];
    public $decline = [];
    public $justification = [];

    protected $listeners = ['statusUpdated' => '$refresh'];

    public function mount(Project $project, string $page = null)
    {
        if ($project) {
            $this->project = $project;
            $this->page = $page;
        }
        $this->departments = $this->project->stateValidations->where('state', $this->project->phase->to($this->transition)->label())->first();

    }

    public function render()
    {

        return view('livewire.projectsInternal.layout.project-internal-navigation');
    }

    public function changePhase()
    {
        if (isset($this->departments->validations) && count($this->departments->validations) >= 1) {
            $data = $this->departments->validations;
            foreach ($this->accept as $index => $item) {
                $data[$index]['value'] = 1;
                $data[$index]['description'] = $this->justification[$index];
            }
            foreach ($this->decline as $index => $item) {
                $data[$index]['value'] = 0;
                $data[$index]['description'] = $this->justification[$index];
            }
            $sumValidation = collect($data)->sum('value');
            if ($sumValidation === count($data)) {
                $this->departments->validations = $data;
                $this->departments->status = ProjectStateValidations::STATUS_VALIDATED;
                $this->user_id = user()->id;
                $this->departments->save();
                $this->project->phase->transitionTo($this->project->phase->to($this->transition));
                flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 0)]))->success();
            } else {
                flash(trans_choice('messages.error.updated', 0, ['type' => trans_choice('general.project', 0)]))->error()->livewire($this);
            }
        } else {
            $this->project->phase->transitionTo($this->project->phase->to($this->transition));
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 0)]))->success()->livewire($this);
        }
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->reset([
            'transition',
            'resume',
            'accept',
            'decline',
            'justification',
            'show',
        ]);
        $this->emit('closeModalValidations');
        $this->emitSelf('statusUpdated');
    }
}
