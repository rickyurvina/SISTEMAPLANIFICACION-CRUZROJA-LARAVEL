<?php

namespace App\Http\Livewire\Projects\Lessons;

use App\Abstracts\TableComponent;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectLearnedLessons;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectLessonsLearnedIndex extends TableComponent
{
    use WithPagination;

    public $search = '';

    public $project;

    public int $viewGrid = 1;

    protected $queryString = [
        'search' => ['except' => ''],

    ];

    protected $listeners = ['updateLessons' => '$refresh'];

    public function mount(Project $project)
    {
        $this->project = $project->load(['lessonsLearned']);
    }

    public function render()
    {
        $lessonsLearned = ProjectLearnedLessons::where('prj_project_id', $this->project->id)->when(!empty($this->search), function (Builder $query) {
            $query->where(function ($q) {
                $q->where('background', 'iLike', '%' . $this->search . '%')
                    ->orWhere('causes', 'iLike', '%' . $this->search . '%')
                    ->orWhere('learned_lesson', 'iLike', '%' . $this->search . '%')
                    ->orWhere('corrective_lesson', 'iLike', '%' . $this->search . '%')
                    ->orWhere('evidences', 'iLike', '%' . $this->search . '%')
                    ->orWhere('recommendations', 'iLike', '%' . $this->search . '%')
                    ->orWhere('phase', 'iLike', '%' . $this->search . '%')
                    ->orWhere('state', 'iLike', '%' . $this->search . '%')
                    ->orWhere('type', 'iLike', '%' . $this->search . '%')
                    ->orWhere('knowledge', 'iLike', '%' . $this->search . '%');
            });
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.projects.lessons.project-lessons-learned-index', compact('lessonsLearned'));
    }
}
