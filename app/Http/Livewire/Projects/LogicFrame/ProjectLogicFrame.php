<?php

namespace App\Http\Livewire\Projects\LogicFrame;

use App\Abstracts\TableComponent;
use App\Exports\LogicFrameExport;
use App\Jobs\Indicators\Indicator\DeleteIndicator;
use App\Models\Projects\Objectives\ProjectObjectives;

use App\Models\Projects\Project;

use App\Models\Projects\Activities\Task;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProjectLogicFrame extends TableComponent
{
    use Jobs;

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
    public $rule;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'colorPaletteChanged' => '$refresh',
        'activityCreated' => '$refresh',
        'objectiveCreated' => 'loadObjectives',
        'resultCreated' => 'render',
        'servicesCreated' => 'loadObjectives',
        'indicatorCreated' => 'render',
        'loadIndicatorUpdated' => '$refresh',
    ];

    public function mount(Project $project, $messages = null)
    {
        $this->project = $project;
        $this->project->load(
            [
                'objectives.results.indicators',
                'objectives.indicators',
            ]);
        $this->messages = $messages;
        $this->rule = 'required|alpha_num|alpha_dash|max:6|' . Rule::unique('prj_tasks');
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
        return view('livewire.projects.logic_frame.project-logic-frame', compact('results'));
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedObjectives = [];
    }

    public function loadObjectives()
    {
        $this->objectives = $this->project->objectives;
    }

    public function deleteObjective($id)
    {
        $objective = ProjectObjectives::with(['results'])->find($id);
        if ($objective->results->count() > 0 || $objective->indicators->count() > 0) {
            flash('No se puede eliminar, resultados asociados')->warning()->livewire($this);
        } else {
            $objective->delete();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.objectives_name', 1)]))->success()->livewire($this);
        }
    }

    public function delete($id)
    {
        $result = Task::with(['indicators'])->find($id);
        if ($result->indicators->count() > 0 || $result->childs->count() > 0) {
            flash('No se puede eliminar, indicadores o hijos asociados')->warning()->livewire($this);
        } else {
            $result->delete();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.result', 1)]))->success()->livewire($this);
        }
    }

    public function deleteIndicator($id)
    {
        $response = $this->ajaxDispatch(new DeleteIndicator($id));
        if ($response['success']) {
            if ($response['data']) {
                $message = trans_choice('messages.error.indicator_with_progress', 1, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->error()->livewire($this);
            } else {
                $message = trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->success()->livewire($this);
            }
        } else {
            $message = $response['message'];
            flash($message)->error()->livewire($this);
        }

    }

    /**
     * @param int $projectId
     * @return BinaryFileResponse
     */
    public function downloadLogicFrameExcel(int $projectId): BinaryFileResponse
    {
        $projectName = Project::findOrFail($projectId)->name;
        return Excel::download(new LogicFrameExport($projectId), 'MarcoLogico_' . $projectName . '.xlsx');
    }
}
