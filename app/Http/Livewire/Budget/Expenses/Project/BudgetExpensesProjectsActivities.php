<?php

namespace App\Http\Livewire\Budget\Expenses\Project;

use App\Models\Budget\Transaction;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class BudgetExpensesProjectsActivities extends Component
{

    public $transaction;

    public array $selectedProjects = [];

    public $projects;

    public $search = '';

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        $this->projects = Project::whereIn('phase', [Project::PHASE_PLANNING, Project::PHASE_IMPLEMENTATION])->get();
        $activities = Task::with([
            'responsible',
            'project',
            'responsible',
        ])
            ->whereHas('project', function ($query) {
                $query->whereIn('phase', [Project::PHASE_PLANNING, Project::PHASE_IMPLEMENTATION]);
            })->when(!empty($this->search), function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('code', 'iLike', '%' . $this->search . '%')
                        ->orWhere('text', 'iLike', '%' . $this->search . '%');
                });
            })->when(count($this->selectedProjects) > 0, function (Builder $query) {
                $query->whereIn('project_id', $this->selectedProjects);
            })->orderBy('project_id', 'asc')
            ->where('type', 'task');

        $total = 0;
        foreach ($activities->get() as $activity) {
            $total += $activity->getTotalBudget($this->transaction)->getAmount();
        }

        $total = money($total);
        $activities = $activities->paginate(setting('default.list_limit', '25'));

        return view('livewire.budget.expenses.project.budget-expenses-projects-activities', compact('activities', 'total'));
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedProjects = [];
    }
}
