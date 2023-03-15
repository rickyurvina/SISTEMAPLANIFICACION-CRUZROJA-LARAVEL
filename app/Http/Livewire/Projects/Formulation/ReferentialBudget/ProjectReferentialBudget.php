<?php

namespace App\Http\Livewire\Projects\Formulation\ReferentialBudget;

use App\Http\Livewire\Projects\CRUD\Projects;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ProjectReferentialBudget extends Component
{

    public $project;

    public array $plans = [];
    public $existsResults = false;
    public $funders;
    public array $totals = [];
    public $results;
    public $messages;

    public function mount(Project $project, $messages = null)
    {
        $this->project = $project->load(['referentialBudgets', 'funders']);
        if ($project->funders) {
            $this->funders = $project->funders;
        }
        $this->results = $this->project->referentialBudgets;

        foreach ($project->referentialBudgets as $result) {
            if ($result->funders_amount) {
                foreach ($result->funders_amount as $rs) {
                    if (array_key_exists($result->id, $this->plans)) {
                        $this->plans[$result->id] += $rs;
                    } else {
                        $this->plans[$result->id] = $rs;
                    }
                }
            }
        }
        $this->messages = $messages;
    }

    public function updatedPlans()
    {
        $totalBudget = 0;
        foreach ($this->plans as $index => $plan) {
            $result = \App\Models\Projects\ProjectReferentialBudget::find($index);
            if (is_numeric(array_sum($plan))) {
                $items[] = $plan;
                $result->funders_amount = $items;
                $result->amount = array_sum($plan);
                $result->save();
                $totalBudget += array_sum($plan);
                $items = [];
            } else {
                flash('Solo se aceptan numeros')->warning()->livewire($this);
            }
        }
        $this->project->estimated_amount = $totalBudget;
        $this->project->save();
    }


    public function render()
    {
        return view('livewire.projects.formulation.referential_budget.project-referential-budget');
    }
}

