<?php

namespace App\Http\Livewire\ProjectsInternal\Governance;

use App\Models\Projects\Project;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectMembersGovernance extends Component
{
    use Jobs;

    public $project;

    public string $subsidiary;

    public $subsidiaries = [];
    public $subsidiariesAux = [];
    public $subsidiariesSelect = [];

    public $area;
    public $areas = [];

    public $executorAreas = [];
    public $executorAreasAux = [];
    public $executorAreasSelect = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->subsidiary = $this->project->company->name;
    }

    public function render()
    {
        return view('livewire.projectsInternal.governance.project-members-governance');
    }
}
