<?php

namespace App\Http\Livewire\ProjectsInternal\Reschedulings;

use App\Models\Projects\ProjectRescheduling;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectApproveRescheduling extends Component
{
    use Jobs;

    public $description;
    public $phase;
    public $status;
    public $approvedId;
    public $project;
    public $rescheduling;

    protected $listeners = ['openApproveRescheduling'];

    public function openApproveRescheduling(int $id)
    {
        $this->rescheduling = ProjectRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->phase = $this->rescheduling->phase;
        $this->project = $this->rescheduling->project;
    }

    public function render()
    {
        return view('livewire.projectsInternal.reschedulings.project-approve-rescheduling');
    }

    public function approve()
    {
        $this->project->phase = $this->phase;
        $this->rescheduling->status = ProjectRescheduling::STATUS_APPROVED;
        $this->rescheduling->approved_id = user()->id;
        $this->rescheduling->save();
        $this->project->save();
        flash('Aprobado satisfactoriamente')->success();
        return redirect()->route('projects.reschedulingsInternal', $this->project->id);
    }
}
