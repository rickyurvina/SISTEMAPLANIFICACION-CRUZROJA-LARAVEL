<?php

namespace App\Http\Livewire\Projects\Activities;

use App\Abstracts\TableComponent;
use App\Jobs\Indicators\Indicator\DeleteIndicator;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Objectives\ProjectObjectives;
use App\Models\Projects\Project;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class ProjectResultsActivities extends TableComponent
{
    use Jobs;

    public int $projectId;
    public $project;
    public $show;
    use WithPagination;

    public $search = '';
    public array $selectedResults = [];
    public bool $showProgramPanel = true;
    public $messages;
    public $results;
    public $resultId;
    public $objectives;

    protected $queryString = [
        'search' => ['except' => ''],
    ];
    protected $listeners =
        [
            'colorPaletteChanged' => '$refresh',
            'activityCreated' => '$refresh',
            'indicatorCreated' => '$refresh',
            'loadIndicatorUpdated' => '$refresh',
            'updateResultsActivities' => '$refresh',
            'indicatorUpdated' => 'render'
        ];

    public function mount(Project $project, $resultId = null)
    {
        if ($resultId) {
            $this->resultId = $resultId;
        }
        $tasks = $project->tasks;
        $start_date = $tasks->min('start_date');
        $end_date = $tasks->max('end_date');
        if ($project->start_date != $start_date) {
            $project->start_date = $start_date;
            $project->save();
        }
        if ($project->end_date != $start_date) {
            $project->end_date = $end_date;
            $project->save();
        }
    }

    public function render()
    {
        $this->objectives = ProjectObjectives::with(
            [
                'results.indicator',
                'results.goals',
                'results.responsible',
                'results.indicators',
                'results.workLogs',
                'results.company',
                'indicators.user',
                'indicators.indicatorUnit',
                'results' => function ($q) {
                    $q->when(count($this->selectedResults) > 0, function (Builder $query) {
                        $query->whereIn('id', $this->selectedResults);
                    });
                }
            ])
            ->where('prj_project_id', $this->project->id)->get();
        $this->results = Task::with([
            'indicator.indicatorUnit',
            'goals',
            'responsible',
            'indicators.indicatorUnit',
            'indicators.user',
            'workLogs',
            'company',
        ])->orderBy('id', 'asc')->where('project_id', $this->project->id)
            ->where('parent', '!=', 'root')
            ->where('type', 'project')
            ->get();
        $activities = Task::with([
            'goals',
            'responsible',
            'indicators.indicatorUnit',
            'indicators.user',
            'goals',
            'workLogs',
            'company',
        ])->orderBy('parent', 'asc')->when(count($this->selectedResults) > 0, function (Builder $query) {
            $query->whereIn('parent', $this->selectedResults);
        })->orderBy('id', 'asc')
            ->where('project_id', $this->project->id)
            ->where('type', 'task')
            ->search('text', $this->search)
            ->get();
        return view('livewire.projects.activities.project-results-activities', compact('activities'));
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedResults = [];
    }

    public function loadObjectives()
    {
        $this->project->refresh();
    }


    public function deleteResult($id)
    {
        $result = Task::find($id);
        if ($result->childs->count() > 0 || $result->indicators->count() > 0) {
            flash('No se puede eliminar, elementos asociados')->warning()->livewire($this);
        } else {
            $result->delete();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.result', 1)]))->success()->livewire($this);
        }
        $this->loadObjectives();
    }

    public function deleteIndicator($id)
    {
        $response = $this->ajaxDispatch(new DeleteIndicator($id));
        if ($response['success']) {
            $message = trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.indicators', 1)]);
            flash($message)->success();
        } else {
            $message = $response['message'];
            flash($message)->error();
        }
        return redirect()->route('projects.activities_results', $this->project->id);
    }
}
