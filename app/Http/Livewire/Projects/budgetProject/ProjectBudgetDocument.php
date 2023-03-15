<?php

namespace App\Http\Livewire\Projects\BudgetProject;

use App\Models\Budget\Transaction;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\States\TransactionDetails\Approved;
use App\States\TransactionDetails\Draft;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectBudgetDocument extends Component
{
    use WithPagination;

    public $transaction;
    public $search = '';
    public $account;
    public $typeBudgetIncome = true;
    public $typeBudgetExpense;
    public $levelIncomeSelected;
    public $project;

    protected $listeners = ['updateIndexBudget' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->transaction = Transaction::where('year', $project->year)
            ->where('type', Transaction::TYPE_PROFORMA)->withoutGlobalScopes()->first();
    }

    public function render()
    {
        $activities = Task::with([
            'responsible',
            'indicator',
            'accounts.transactionsPrDraft',
            'project'
        ])
            ->when(!empty($this->search), function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('code', 'iLike', '%' . $this->search . '%')
                        ->orWhere('text', 'iLike', '%' . $this->search . '%');
                });
            })->where('project_id', $this->project->id)
            ->where('type', 'task')
            ->paginate(setting('default.list_limit', '25'));
        return view('livewire.projects.budget-project.project-budget-document', compact('activities'));
    }

    public function clearFilters()
    {
        $this->search = '';
    }

    public function approveAllBudget()
    {
        $activities = Task::with([
            'accounts.transactionsPrDraft',
        ])->where('project_id', $this->project->id)
            ->where('type', 'task')->get();
        $transactionsDetails = $activities->pluck('accounts')->collapse()->pluck('transactionsPrDraft')->collapse()->where('status', Draft::label());
       if ($transactionsDetails->count()){
           try {
               DB::beginTransaction();
               foreach ($transactionsDetails as $transactionsDetail) {
                   $transactionsDetail->status = Approved::label();
                   $transactionsDetail->approved_by = user()->id;
                   $transactionsDetail->save();
               }
               DB::commit();
           } catch (\Exception $exception) {
               DB::rollBack();
               flash($exception->getMessage())->error()->livewire($this);
           }
       }else{
           flash('No existen partidas presupuestarias por aprobar')->warning()->livewire($this);
       }
    }
}
