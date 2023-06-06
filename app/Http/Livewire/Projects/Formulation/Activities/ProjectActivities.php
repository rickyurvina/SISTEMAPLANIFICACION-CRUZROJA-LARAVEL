<?php

namespace App\Http\Livewire\Projects\Formulation\Activities;

use App\Models\Auth\User;

use App\Models\Projects\Project;
use App\Models\Projects\Activities\Task;
use Livewire\Component;

class ProjectActivities extends Component
{

    public $project;
    public $time = 0;
    public array $plans = [];
    public $existsResults = false;
    public $messagesList;
    public $results;
    public $limitSup;
    public $limitMin;

    protected $listeners = ['timeUpdated'];

    public function mount(Project $project, $messagesList = null)
    {
        $this->project = $project->load(['objectives.results']);
        $this->results = Task::where('project_id', $project->id)
            ->orderBy('id', 'asc')
            ->where('type', '!=', 'task')
            ->where('parent', '!=', 'root')
            ->get();
        if ($project->estimated_time) {
            $this->time = $project->estimated_time;
            foreach ($project->objectives as $objective) {
                foreach ($objective->results as $result) {
                    if ($result->planning) {
                        $this->plans[$result->id] = $result->planning;
                    }
                }
            }
        }
        foreach ($this->project->objectives as $objectives) {
            foreach ($objectives->results as $result) {
                $this->existsResults = true;
            }
        }
        $this->messagesList = $messagesList;

        $this->limitMin = 1;
        if ($this->time < 13) {
            $this->limitSup = $this->time;
        } else {
            $this->limitSup = 12;
        }
    }

    public function timeUpdated(Project $project, $messagesList = null)
    {
        $this->messagesList = $messagesList;
        $this->reset(['plans', 'time', 'project']);
        $this->mount($project);
    }

    public function updatedPlans()
    {

        foreach ($this->plans as $index => $plan) {
            $result = Task::find($index);
            foreach ($plan as $index2 => $item) {
                if ($result->id == $index) {
                    $rss[$index2] = [$index2 => $item];
                }
            }
            $result->planning = $rss ?? null;
            $result->save();
            $rss = [];
        }

    }

    public function render()
    {
        return view('livewire.projects.formulation.activities.project-activities');
    }

    public function selectRow($resultId)
    {
        for ($i = 1; $i <= $this->time; $i++) {
            $this->plans[$resultId][$i] = true;
        }
        $this->updatedPlans();
    }

    public function plusTime()
    {
        $this->limitSup += 12;
        $this->limitMin += 12;
        if ($this->limitSup > $this->time) {
            $this->limitSup = $this->time;
            $this->limitMin = $this->limitSup - 11;
        }
    }

    public function decreaseTime()
    {
        $this->limitSup -= 12;
        $this->limitMin -= 12;
        if ($this->limitSup < 12) {
            $this->limitSup = 12;
            $this->limitMin = 1;
        }
    }
}
