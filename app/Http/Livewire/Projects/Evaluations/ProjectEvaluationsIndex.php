<?php

namespace App\Http\Livewire\Projects\Evaluations;


use App\Models\Projects\Project;
use App\Models\Projects\ProjectEvaluation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectEvaluationsIndex extends Component
{

    use WithPagination;

    public $search = '';

    public $project;

    public int $viewGrid = 1;

    protected $listeners = ['updateEvaluations' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $evaluations = ProjectEvaluation::where('prj_project_id', $this->project->id)->when(!empty($this->search), function (Builder $query) {
            $query->where(function ($q) {
                $q->where('name', 'iLike', '%' . $this->search . '%')
                    ->orWhere('phase', 'iLike', '%' . $this->search . '%')
                    ->orWhere('state', 'iLike', '%' . $this->search . '%')
                    ->orWhere('systematization', 'iLike', '%' . $this->search . '%')
                    ->orWhere('user_id', 'iLike', '%' . $this->search . '%')
                    ->orWhere('methodology', 'iLike', '%' . $this->search . '%');
            });
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.projects.evaluations.project-evaluations-index', compact('evaluations'));
    }
}
