<?php

namespace App\Http\Livewire\ProjectsInternal\Formulation\Articulations;

use App\Models\Common\Catalog;
use App\Models\Indicators\Threshold\Threshold;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectArticulations;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProjectShowArticulations extends Component
{

    protected $listeners = ['projectArticulated' => 'mount'];

    public $projectId = null;
    public ?Collection $articulations;
    public $messagesList;


    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->articulations = $this->project->articulations;
        $this->messagesList = Catalog::CatalogName('help_messages')->first()->details;
    }

    public function render()
    {
        return view('livewire.projectsInternal.formulation.articulations.project-show-articulations');
    }
}
