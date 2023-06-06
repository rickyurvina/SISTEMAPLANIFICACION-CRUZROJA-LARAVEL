<?php

namespace App\Http\Livewire\Projects\Acquisitions;


use App\Jobs\Projects\ProjectDeleteAcquisition;
use App\Models\Projects\Project;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectAcquisitions extends Component
{
    use Jobs;

    public $projectId = null;

    public ?Project $project = null;

    protected $listeners = [
        'updateAcquisitionsList' => 'render',
    ];

    public function mount(Project $project)
    {
        $this->projectId = $project->id;
        $this->project = $project;

    }

    public function render()
    {
        $acquisitions = $this->project->acquisitions;

        return view('livewire.projects.acquisitions.project-acquisitions', compact('acquisitions'));
    }

    public function delete($id)
    {

        $response = $this->ajaxDispatch(new ProjectDeleteAcquisition($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.prj_acquisitions', 1)]))->success()->livewire($this);
           $this->emitSelf('updateAcquisitionsList');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
