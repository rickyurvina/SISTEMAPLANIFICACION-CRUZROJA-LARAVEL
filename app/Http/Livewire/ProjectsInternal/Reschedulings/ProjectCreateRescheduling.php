<?php

namespace App\Http\Livewire\ProjectsInternal\Reschedulings;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectRescheduling;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectCreateRescheduling extends Component
{
    use Jobs;

    public $description;
    public $phase;
    public $status;
    public $approvedId;
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projectsInternal.reschedulings.project-create-rescheduling');
    }

    public function resetForm()
    {
        $this->reset([
            'description',
            'phase',
            'status',
        ]);
    }

    public function create()
    {
        $data = $this->validate([
            'description' => 'required',
            'phase' => 'required',
        ]);
        $data += [
            'phase' => $this->phase,
            'status' => ProjectRescheduling::STATUS_OPENED,
            'prj_project_id' => $this->project->id,
            'user_id' => user()->id,
        ];

        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateRescheduling($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.rescheduling', 0)]))->success();
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error();
        }
        return redirect()->route('projects.reschedulingsInternal', $this->project->id);
    }
}
