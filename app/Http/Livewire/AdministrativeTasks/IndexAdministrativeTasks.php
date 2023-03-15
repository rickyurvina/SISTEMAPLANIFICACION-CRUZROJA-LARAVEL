<?php

namespace App\Http\Livewire\AdministrativeTasks;

use App\Jobs\AdministrativeTasks\DeleteAdministrativeTask;
use App\Models\AdministrativeTasks\AdministrativeTask;
use App\Models\Projects\Project;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class IndexAdministrativeTasks extends Component
{
    use Jobs;
    public $projects;
    public $selectedProjects = [];
    public $search = '';

    public $idProject;
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = ['administrativeAdded' => 'render'];

    public function mount(int $idProject = null)
    {
        if ($idProject) {
            $this->idProject = $idProject;
        }
        $this->projects = Project::whereIn('phase', [Project::PHASE_PLANNING, Project::PHASE_IMPLEMENTATION])->get();
    }

    public function render()
    {
        $administrativeTasks = AdministrativeTask::with([
            'responsible',
            'subTasks',
            'project'
        ])
            ->orderBy('id', 'asc')
            ->when(count($this->selectedProjects) > 0, function (Builder $query) {
                $query->whereIn('project_id', $this->selectedProjects);
            })
            ->when($this->idProject, function ($q) {
                $q->where('project_id', $this->idProject);
            })
            ->search('name', $this->search)
            ->paginate(setting('default.list_limit', '25'));

        return view('livewire.administrativeTasks.index-administrative-tasks', compact('administrativeTasks'));
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedProjects = [];
    }

    public function delete(int $administrativeTask_id)
    {
        //
        $task = AdministrativeTask::find($administrativeTask_id);
        $data = [
            'id' => $administrativeTask_id
        ];
        $response = $this->ajaxDispatch(new DeleteAdministrativeTask($data));
        if ($response['success']) {
            flash('messages.success.deleted', 0)->success();
        } else {
            flash($response['message'])->error();
        }
    }
}
