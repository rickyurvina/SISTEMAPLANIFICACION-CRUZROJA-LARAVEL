<?php

namespace App\Http\Livewire\ProjectsInternal\LogicFrame;

use App\Abstracts\TableComponent;
use App\Jobs\Indicators\Indicator\DeleteIndicator;
use App\Models\Poa\Poa;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectReferentialBudget;
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
    public $projectAdvance;
    public $poa;

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
        $this->objectives = $this->project->objectives;
        $this->projectAdvance = $project->tasks->where('parent', 'root')->first()->progress;
        $currentYear = (int)date('Y');
        $this->poa = Poa::where('year', $currentYear)->first();
    }

    public function render()
    {
        $this->results = Task::with([
            'indicator',
            'goals',
            'responsible',
            'indicators',
            'goals',
            'workLogs',
            'company',
        ])->where('project_id', $this->project->id)
            ->where('parent', '!=', 'root')
            ->where('type', 'project')
            ->when(!(user()->hasRole('super-admin')), function ($q) {
                $q->where('owner_id', user()->id);
            })
            ->get();
        $activities = Task::with([
            'goals',
            'responsible',
            'indicators',
            'goals',
            'workLogs',
            'company',
        ])->when(count($this->selectedResults) > 0, function (Builder $query) {
            $query->whereIn('parent', $this->selectedResults);
        })->orderBy('id', 'asc')
            ->where('project_id', $this->project->id)
            ->where('type', 'task')
            ->when(!(user()->hasRole('super-admin')), function ($q) {
                $q->where('owner_id', user()->id);
            })
            ->search('text', $this->search)
            ->paginate(setting('default.list_limit', '25'));
        return view('livewire.projectsInternal.logic_frame.project-results-activities', compact('activities'));
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
            $rb = ProjectReferentialBudget::where('task_id', $id)->first();
            if ($rb) {
                $rb->delete();
            }
            $result->delete();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.result', 1)]))->success()->livewire($this);
        }
        $this->loadObjectives();
    }

    public function deleteIndicator($id)
    {
        $response = $this->ajaxDispatch(new DeleteIndicator($id));
        if ($response['success']) {
            if ($response['data']) {
                $message = trans_choice('messages.error.indicator_with_progress', 1, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->error();
            } else {
                $message = trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->success();
            }
        } else {
            $response['redirect'] = route('indicators.index');
            $message = $response['message'];
            flash($message)->error();
        }
        return redirect()->route('projects.logic-frame', $this->project->id);

    }
}
