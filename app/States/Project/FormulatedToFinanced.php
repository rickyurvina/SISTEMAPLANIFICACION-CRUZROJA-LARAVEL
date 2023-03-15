<?php

namespace App\States\Project;

use App\Models\Projects\Project;
use Spatie\ModelStates\Transition;

class FormulatedToFinanced extends Transition
{

    private Project $project;


    public function __construct(Project $project)
    {

        $this->project = $project;
    }

    public function handle()
    {
        $this->project->status = new Pending($this->project);
        $this->project->phase = new Planning($this->project);
        $this->project->save();
        return $this->project;
    }

}