<?php

namespace App\States\Project;

use App\Models\Projects\Project;
use Spatie\ModelStates\Transition;

class PendingToCompleted extends Transition
{

    private Project $project;


    public function __construct(Project $project)
    {

        $this->project = $project;
    }

    public function handle()
    {
        $this->project->status = new Execution($this->project);
        $this->project->phase = new Implementation($this->project);
        $this->project->save();
        return $this->project;
    }

}