<?php

namespace App\States\Project;

use App\Models\Projects\Project;
use Spatie\ModelStates\Transition;

class PlanningToStartUp extends Transition
{

    private Project $project;


    public function __construct(Project $project)
    {

        $this->project = $project;
    }

    public function handle()
    {
        $this->project->status = new InProcess($this->project);
        $this->project->phase = new StartUp($this->project);
        $this->project->save();
        return $this->project;
    }

}