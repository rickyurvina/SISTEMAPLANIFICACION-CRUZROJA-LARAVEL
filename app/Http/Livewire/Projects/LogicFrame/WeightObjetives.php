<?php

namespace App\Http\Livewire\Projects\LogicFrame;

use App\Models\Projects\Activities\Task;
use App\Models\Projects\Objectives\ProjectObjectives;
use App\Models\Projects\Project;
use Livewire\Component;

class WeightObjetives extends Component
{
    public $sumWeights = null;
    public $even;
    public $weights = [];
    public $objectives = null;

    public function mount(int $projectId)
    {
        $project = Project::find($projectId);
        $this->objectives = $project->objectives;
        $i = 0;
        $this->even = false;
        foreach ($this->objectives as $item) {
            $this->weights[$i]['id'] = $item->id;
            $this->weights[$i++]['weight'] = $item->weight * 100;
        }
    }

    public function render()
    {
        $totalActivities = count($this->weights);
        $evenWeight = 100;
        if ($totalActivities > 0) {
            $evenWeight = 100 / $totalActivities;
        }
        $this->sumWeights = 0;
        $i = 0;
        foreach ($this->weights as $item) {
            if ($this->even) {
                $this->sumWeights += $evenWeight;
                $this->weights[$i]['weight'] = number_format($evenWeight, 2, '.', ',');
            } else {
                $this->sumWeights += $item['weight'];
                $this->weights[$i]['weight'] = number_format($item['weight'], 2, '.', ',');
            }
            $i++;
        }
        $this->even = false;
        return view('livewire.projects.logic_frame.weight-objetives');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedWeights()
    {
        $this->sumWeights = 0;
        foreach ($this->weights as $weight) {
            $this->sumWeights += $weight['weight'] > 0 ? $weight['weight'] : 0;
        }
        $this->sumWeights = round($this->sumWeights, 2);
        $this->emit('updateResultsActivities');
    }

    public function store()
    {
        foreach ($this->weights as $item) {
            ProjectObjectives::where('id', $item['id'])->update(['weight' => $item['weight'] / 100]);
        }
        $this->resetForm();
        $this->emit('closeModalObjectivesWeight');
        $this->emit('updateResultsActivities');

    }
}
