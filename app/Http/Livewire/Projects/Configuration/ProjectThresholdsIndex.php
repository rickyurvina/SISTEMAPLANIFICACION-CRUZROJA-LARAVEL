<?php

namespace App\Http\Livewire\Projects\Configuration;

use App\Models\Projects\Activities\Task;
use App\Models\Projects\Configuration\ProjectThreshold;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectLearnedLessons;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectThresholdsIndex extends Component
{
    use WithPagination, Jobs;

    public array $selectedProjects = [];
    public $search = '';
    public $projects = [];

    protected $listeners = ['refreshIndexThresholds' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->projects = Project::all();
    }

    public function render()
    {
        $search = $this->search;
        $tasks = Task::whereIn('project_id', $this->selectedProjects)->pluck('id');
        $thresholds = ProjectThreshold::with(['thresholdable'])
            ->when(count($tasks) > 0, function (Builder $query)use ($tasks) {
            $query->whereIn('thresholdable_id', $tasks);
        })->when($search, function ($q) {
            $q->where(function ($query) {
                $query->where('description', 'iLIKE', '%' . $this->search . '%');
            });
        })->paginate(setting('default.list_limit', '25'));

        return view('livewire.projects.configuration.project-thresholds-index', compact('thresholds'));
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectedProjects',
                'search',
            ]);
    }
}
