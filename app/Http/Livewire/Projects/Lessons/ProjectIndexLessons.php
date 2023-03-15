<?php

namespace App\Http\Livewire\Projects\Lessons;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectLearnedLessons;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectIndexLessons extends Component
{
    use WithPagination, Jobs;

    public $projects;
    public array $selectedProjects = [];
    public bool $showProgramPanel = true;
    public $objectives;
    public array $resultSelected;
    public $project;
    public int $projectId;

    public $show;

    public $search = '';

    public int $viewGrid = 1;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->projects = Project::get();

    }

    public function render()
    {
        $lessons = ProjectLearnedLessons::with(['project'])->when(count($this->selectedProjects) > 0, function (Builder $query) {
            $query->whereIn('prj_project_id', $this->selectedProjects);
        })->orderBy('prj_project_id', 'asc')
            ->search('background', $this->search)
            ->paginate(setting('default.list_limit', '25'));;
        return view('livewire.projects.lessons.project-index-lessons', compact('lessons'));
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedProjects = [];
    }
}
