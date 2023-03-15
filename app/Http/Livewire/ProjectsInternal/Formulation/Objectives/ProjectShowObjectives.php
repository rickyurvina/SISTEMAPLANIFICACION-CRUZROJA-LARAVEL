<?php

namespace App\Http\Livewire\ProjectsInternal\Formulation\Objectives;

use App\Abstracts\TableComponent;
use App\Jobs\Indicators\Indicator\DeleteIndicator;
use App\Models\Projects\Objectives\ProjectObjectives;

use App\Models\Projects\Project;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\ProjectReferentialBudget;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ProjectShowObjectives extends TableComponent
{
    public int $projectId;
    public $project;
    public array $resultSelected;
    public $show;
    use WithPagination;
    public $search = '';
    public $objectives;
    public array $selectedObjectives = [];
    public bool $showProgramPanel = true;
    public $messages;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'colorPaletteChanged' => '$refresh',
        'activityCreated' => '$refresh',
        'objectiveCreated' => 'loadObjectives',
        'resultCreated' => 'loadObjectives',
        'servicesCreated' => 'loadObjectives'
    ];

    public function mount(Project $project, $messages=null)
    {
        $this->project = $project;
        $this->messages=$messages;
        $this->loadObjectives();
    }

    public function render()
    {
        $results = Task::with(['indicators','objective'])->when(count($this->selectedObjectives) > 0, function (Builder $query) {
            $query->whereIn('objective_id', $this->selectedObjectives);
        })->orderBy('objective_id')
            ->orderBy('id')
            ->where('project_id', $this->project->id)
            ->where('parent', '!=', 'root')
            ->where('type', 'project')
            ->search('text', $this->search)
            ->collect();
        return view('livewire.projectsInternal.formulation.objectives.project-show-objectives', compact('results'));
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedObjectives = [];
    }

    public function loadObjectives()
    {
        $this->project->refresh();
        $this->objectives = $this->project->objectives;
    }

    public function deleteObjective($id)
    {
        $objective = ProjectObjectives::with(['results'])->find($id);
        if ($objective->results->count() > 0) {
            flash('No se puede eliminar, resultados asociados')->warning()->livewire($this);
        } else {
            $objective->delete();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.objectives_name', 1)]))->success()->livewire($this);
        }
        $this->loadObjectives();
    }

    public function deleteActivity($id)
    {
        $activity = Task::find($id);
        $activity->delete();
        flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.activity', 1)]))->success()->livewire($this);
        $this->mount($this->project);
    }

    public function deleteResult($id)
    {
        $result = Task::with(['indicators'])->find($id);
        if ($result->indicators->count() > 0 || $result->childs->count()>0) {
            flash('No se puede eliminar, indicadores o actividades asociados')->warning()->livewire($this);

        } else {
            $referentialBudget=ProjectReferentialBudget::where('task_id',$id);
            $referentialBudget->delete();
            $result->delete();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.result', 1)]))->success()->livewire($this);
        }
        $this->loadObjectives();
    }
}
