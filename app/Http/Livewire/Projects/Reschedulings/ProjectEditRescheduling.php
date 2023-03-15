<?php

namespace App\Http\Livewire\Projects\Reschedulings;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectRescheduling;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectEditRescheduling extends Component
{
    use Jobs;

    public $description;
    public $state;
    public $phase;
    public $status;
    public $approvedId;
    public $project;
    public $rescheduling;
    public $arrayStates = array();

    protected $listeners = ['openEditRescheduling'];

    public function openEditRescheduling(int $id)
    {
        $this->rescheduling = ProjectRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->state = $this->rescheduling->state;
        $this->phase = $this->rescheduling->phase;
        $this->updatedPhase();
    }

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.reschedulings.project-edit-rescheduling');
    }

    public function resetForm()
    {
        $this->reset([
            'description',
            'state',
            'phase',
            'status',
        ]);
    }

    public function edit()
    {
        $data = $this->validate([
            'description' => 'required',
            'state' => 'required',
            'phase' => 'required',
        ]);
        $data += [
            'id' => $this->rescheduling->id,
            'phase' => $this->phase,
            'state' => $this->state,
            'status' => ProjectRescheduling::STATUS_OPENED,
            'prj_project_id' => $this->project->id,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectEditRescheduling($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.rescheduling', 0)]))->success();
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error();
        }
        return redirect()->route('projects.reschedulings', $this->project->id);
    }


    public function updatedPhase()
    {
        $rss = array();
        switch ($this->phase) {
            case Project::PHASE_START_UP:
                $rss = Project::STATUSES_START_UP;
                break;
            case Project::PHASE_PLANNING:
                $rss = Project::STATUSES_PLANNING;
                break;
            case Project::PHASE_IMPLEMENTATION:
                $rss = Project::STATUSES_IMPLEMENTATION;
                break;
        }
        $this->arrayStates = $rss;
    }
}
