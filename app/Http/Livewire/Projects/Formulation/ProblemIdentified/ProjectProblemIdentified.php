<?php

namespace App\Http\Livewire\Projects\Formulation\ProblemIdentified;

use App\Models\Projects\Project;
use Livewire\Component;

class ProjectProblemIdentified extends Component
{

    public $project;
    public $messages;


    public function mount(Project $project, $messages=null)
    {
        $this->project = $project;
        $this->messages=$messages;
    }

    public function render()
    {
        return view('livewire.projects.formulation.problem_identified.project-problem-identified');
    }
}
