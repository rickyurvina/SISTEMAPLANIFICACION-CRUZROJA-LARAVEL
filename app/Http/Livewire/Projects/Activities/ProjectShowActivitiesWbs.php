<?php

namespace App\Http\Livewire\Projects\Activities;

use App\Models\Projects\Project;
use Livewire\Component;

class ProjectShowActivitiesWbs extends Component
{
    public $project;
    public $objectives;

    public function mount(int $projectId)
    {
        $this->project = Project::find($projectId);
    }

    public function render()
    {
        $this->objectives = $this->project->objectives;
        $data = [
            'name' => $this->project->name,
            'children' => []
        ];
        $child = array();

        $i = 0;
        foreach ($this->objectives as $objective) {
            $child = ['name' => $objective->name, 'children' => []];
            array_push($data['children'], $child);
            if ($objective->results->count() > 0) {
                $j = 0;
                foreach ($objective->results as $result) {
                    $child = ['name' => $result->text, 'children' => []];
                    array_push($data['children'][$i]['children'], $child);
                    if ($result->childs->count() > 0) {
                        foreach ($result->childs as $activity) {
                            $child = ['name' => $activity->text, 'value' => $activity->progress, 'children' => []];
                            array_push($data['children'][$i]['children'][$j]['children'], $child);
                        }
                    }
                    $j++;
                }
            }
            $i++;
        }

        return view('livewire.projects.activities.project-show-activities-wbs', compact('data'));
    }
}
